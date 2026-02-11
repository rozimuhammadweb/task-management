<?php

namespace App\Enums;
enum RoleEnum: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => __('Admin'),
            self::MANAGER => __('Manager'),
            self::USER => __('User'),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
