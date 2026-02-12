<?php

namespace App\Services\Contracts\Auth;

interface EmailServiceInterface
{
    public function sendOtpEmail(string $email, string $code): bool;

}
