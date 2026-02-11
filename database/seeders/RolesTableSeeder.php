<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RolesTableSeeder extends Seeder
{

    public function run(): void
    {
        foreach (RoleEnum::cases() as $role) {
            Role::findOrCreate($role->value);
        }
    }
}
