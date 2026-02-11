<?php

namespace App\Services\Contracts\Auth;

use App\Services\Contracts\BaseServiceInterface;

interface AuthServiceInterface extends BaseServiceInterface
{
    public function register(array $data);

    public function login(array $data);

    public function logout();

    public function refresh();
}
