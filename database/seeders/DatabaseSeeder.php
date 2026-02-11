<?php

namespace Database\Seeders;

use App\Models\User;
use App\Policies\Base\Contracts\BasePolicyInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            UserPolicySeeder::class,
            TaskPolicySeeder::class,
            UserSeeder::class,
        ]);
    }
}
