<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Policies\Base\BasePolicy;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class BasePolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public string $policy = BasePolicy::class;

    public function run(): void
    {
        foreach ($this->policy::getRolePermissions() as $role_name => $permissions) {

            $role = Role::where('name', $role_name)->first();

            if (!$role) continue;

            foreach ($permissions as $permission) {
                Permission::updateOrCreate(['name' => $permission]);
                $role->givePermissionTo($permission);
            }
        }
    }
}
