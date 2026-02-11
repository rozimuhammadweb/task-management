<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(
        protected Model $model
    ) {
    }

    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    public function find(int|string $id): ?Model
    {
        return $this->model->find($id);
    }

    public function findOrFail(int|string $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function findByUuid(string $uuid): ?Model
    {
        return $this->query()->where('uuid', $uuid)->first();
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    public function paginate(
        $query,
        ?int    $perPage = null,
        array   $columns = ['*'],
        string  $pageName = 'page',
        ?int    $page = null
    ): LengthAwarePaginator|Collection
    {
        return $perPage
            ? $query->paginate($perPage, $columns, $pageName, $page)
            : $query->get($columns);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(int|string $id, array $attributes): ?Model
    {
        $model = $this->find($id);

        if (!$model) {
            return null;
        }

        $model->update($attributes);
        return $model->fresh();
    }

    public function insert(array $rows)
    {
       return $this->model->insert($rows);
    }

    public function delete(int|string $id): bool
    {
        $model = $this->find($id);
        return $model?->delete() ?? false;
    }

    public function forceDelete(int|string $id): bool
    {
        $model = $this->find($id);
        return $model?->forceDelete() ?? false;
    }

    public function restore(int|string $id): bool
    {
        $model = $this->query()->withTrashed()->find($id);
        return $model?->restore() ?? false;
    }

    public function updateOrCreate(array $attributes, array $values = []): Model
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    public function firstOrCreate(array $attributes, array $values = []): Model
    {
        return $this->model->firstOrCreate($attributes, $values);
    }

    public function count($query): int
    {
        return $query->count();
    }

    public function exists($query): bool
    {
        return $query->exists();
    }

    public function first($query, array $columns = ['*']): ?Model
    {
        return $query->first($columns);
    }
}
