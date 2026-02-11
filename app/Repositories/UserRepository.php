<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\User\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByLogin(string $login): ?User
    {
        return $this->model->where('username', $login)->orWhere('email', $login)->first();
    }
}
