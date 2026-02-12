<?php

namespace App\Services\Contracts\Auth;

use App\Services\Contracts\BaseServiceInterface;

interface AuthServiceInterface extends BaseServiceInterface
{
    public function register(array $data);

    public function login(array $data);

    public function sendEmailOtp(string $email): bool;

    public function verifyEmailOtp(string $email, string $code): array;

    public function logout();

    public function refresh();

    public function me();
}
