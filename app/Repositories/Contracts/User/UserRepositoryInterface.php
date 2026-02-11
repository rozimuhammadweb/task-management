<?php

namespace App\Repositories\Contracts\User;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByLogin(string $login);
}
