<?php

namespace App\Policies\Base\Contracts;

interface BasePolicyInterface
{
    public static function getRolePermissions(): array;
}
