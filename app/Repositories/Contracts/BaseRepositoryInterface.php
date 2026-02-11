<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface BaseRepositoryInterface
{
    public function find(int|string $id);

    public function findOrFail(int|string $id);

    public function findByUuid(string $uuid);

    public function all(array $columns = ['*']);

    public function paginate(
        $query,
        ?int    $perPage = null,
        array   $columns = ['*'],
        string  $pageName = 'page',
        ?int    $page = null
    );

    public function create(array $attributes);

    public function update(int|string $id, array $attributes);

    public function delete(int|string $id);

    public function forceDelete(int|string $id);

    public function restore(int|string $id);

    public function insert(array $rows);

    public function updateOrCreate(array $attributes, array $values = []);

    public function firstOrCreate(array $attributes, array $values = []);

    public function count($query): int;

    public function exists($query);

    public function first($query, array $columns = ['*']);
}
