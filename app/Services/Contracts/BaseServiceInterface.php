<?php

declare(strict_types=1);

namespace App\Services\Contracts;

interface BaseServiceInterface
{
    public function get(array $params, bool $pagination = true);

    public function list(array $params = []);

    public function find(int|string $id);

    public function findOrFail(int|string $id);

    public function findByUuid(string $uuid);

    public function create(array $data);

    public function update(int|string $id, array $data);

    public function delete(int|string $id): bool;

    public function insert(array $rows): bool;

    public function updateOrCreate(array $attributes, array $values = []);

    public function count(array $params = []): int;

    public function exists(array $params = []): bool;
}
