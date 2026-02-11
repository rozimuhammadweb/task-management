<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $casts = [
        'name' => RoleEnum::class,
    ];
}
