<?php

namespace App\Services;

use App\Services\Contracts\Auth\EmailServiceInterface;

class EmailService implements EmailServiceInterface
{
    public function sendEmailOtp(string $email, string $code): bool
    {
        return true;
    }
}
