<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Services\Contracts\BaseServiceInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService implements BaseServiceInterface
{
    protected array $filterFields = [];
    protected array $sortFields = [];
    protected array $relations = [];
    protected array $selectFields = [];

    public function __construct(
        protected BaseRepository $repository
    )
    {
    }

    public function get(array $params, bool $pagination = true): LengthAwarePaginator|Collection
    {
        $perPage = $pagination ? ($params['per_page'] ?? 20) : null;

        $query = $this->repository->query();
        $query = $this->applyRelations($query);
        $query = $this->applyFilters($query, $params);
        $query = $this->applySort($query, $params);
        $query = $this->applySelect($query);

        return $this->repository->paginate($query, $perPage);
    }

    public function list(array $params = [])
    {
        $query = $this->repository->query();
        $query = $this->applyRelations($query);
        $query = $this->applyFilters($query, $params);
        $query = $this->applySort($query, $params);
        $query = $this->applySelect($query);

        return $query->get();
    }


    public function find(int|string $id)
    {
        return $this->repository->find($id);
    }

    public function findOrFail(int|string $id)
    {
        return $this->repository->findOrFail($id);
    }

    public function findByUuid(string $uuid)
    {
        return $this->repository->findByUuid($uuid);
    }


    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(int|string $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    public function insert(array $rows): bool
    {
        return $this->repository->insert($rows);
    }

    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->repository->updateOrCreate($attributes, $values);
    }

    protected function applyRelations(Builder $query): Builder
    {
        if (!empty($this->relations)) {
            $query->with($this->relations);
        }

        return $query;
    }

    protected function applySelect(Builder $query): Builder
    {
        if (!empty($this->selectFields)) {
            $query->select($this->selectFields);
        }

        return $query;
    }

    protected function applyFilters(Builder $query, array $params): Builder
    {
        foreach ($this->filterFields as $key => $config) {
            if (!array_key_exists($key, $params) || $this->isEmptyValue($params[$key])) {
                continue;
            }

            $value = $params[$key];
            $type = $config['type'] ?? 'string';

            match ($type) {
                'string_search' => $query->where($key, $value),
                'string' => $query->where($key, 'ilike', "%{$value}%"),
                'exact', 'number', 'bool' => $query->where($key, $value),
                'array' => $query->whereIn($key, $value),
                'not_in' => $query->whereNotIn($key, $value),

                'intarray' => !in_array(0, $value)
                    ? $query->whereRaw("{$key} && ?", ['{' . implode(',', $value) . '}'])
                    : $query,
                'intarrayand' => $query->whereRaw("{$key} @> ?", ['{' . implode(',', $value) . '}']),

                // Date filters
                'date' => $query->whereDate($key, $value),
                'datefrom' => $query->whereDate(str_replace('_from', '', $key), '>=', $value),
                'dateto' => $query->whereDate(str_replace('_to', '', $key), '<=', $value),
                'day' => $query->where($key, '>=', Carbon::now()->subDays((int)$value)),

                // Comparison operators
                'from', '>=' => $query->where($key, '>=', $value),
                'to', '<=' => $query->where($key, '<=', $value),
                '>' => $query->where($key, '>', $value),
                '<' => $query->where($key, '<', $value),

                // JSON filters
                'json' => $this->applyJsonFilter($query, $key, $value, $config),

                // Relation filters
                'r_string', 'r_number' => $this->applyRelationFilter($query, $key, $value, $config),

                // Null check
                'isNull' => $query->whereNull($key),
                'isNotNull' => $query->whereNotNull($key),

                // Between
                'between' => is_array($value) && count($value) === 2
                    ? $query->whereBetween($key, $value)
                    : $query,

                default => $query
            };
        }

        return $query;
    }

    protected function applyJsonFilter(Builder $query, string $key, mixed $value, array $config): Builder
    {
        $jsonType = $config['json_type'] ?? 'string';
        $search = $config['search'] ?? 'string';
        $jsonKey = $config['json_key'] ?? $key;

        if ($jsonType === 'array' && $search === 'string') {
            $query->where("data->{$jsonKey}", 'ilike', "%{$value}%");
        } elseif ($jsonType === 'array' && $search === 'number') {
            $query->where("data->{$jsonKey}", $value);
        }

        return $query;
    }


    protected function applyRelationFilter(Builder $query, string $key, mixed $value, array $config): Builder
    {
        $relation = $config['relation'] ?? null;
        $field = $config['field'] ?? $key;
        $type = $config['type'] ?? 'r_string';

        if (!$relation) {
            return $query;
        }

        return $query->whereHas($relation, function (Builder $q) use ($field, $value, $type) {
            if ($type === 'r_string') {
                $q->where($field, 'ilike', "%{$value}%");
            } elseif ($type === 'r_number') {
                $q->where($field, $value);
            }
        });
    }


    protected function applySort(Builder $query, array $params): Builder
    {
        $sortKey = $params['sort_key'] ?? $this->sortFields['sort_key'] ?? 'id';
        $sortType = $params['sort_type'] ?? $this->sortFields['sort_type'] ?? 'desc';

        // Validate sort direction
        $sortType = in_array(strtolower($sortType), ['asc', 'desc']) ? $sortType : 'desc';

        return $query->orderBy($sortKey, $sortType);
    }


    protected function isEmptyValue(mixed $value): bool
    {
        if (is_null($value)) {
            return true;
        }

        if (is_string($value) && trim($value) === '') {
            return true;
        }

        if (is_array($value) && empty($value)) {
            return true;
        }

        return false;
    }


    public function count(array $params = []): int
    {
        $query = $this->repository->query();
        $query = $this->applyFilters($query, $params);

        return $this->repository->count($query);
    }

    public function exists(array $params = []): bool
    {
        $query = $this->repository->query();
        $query = $this->applyFilters($query, $params);

        return $this->repository->exists($query);
    }
}
