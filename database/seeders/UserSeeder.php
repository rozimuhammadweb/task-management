<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::getUsers() as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'username' => $data['username'],
                    'password' => 'test123',
                    'status' => UserStatus::ACTIVE->value,
                ]
            );
            $user->assignRole($data['role']->value);
        }
    }

    public static function getUsers(): array
    {
        return [
            [
                'email' => 'admin@gmail.com',
                'name' => 'Admin',
                'username' => 'admin',
                'role' => RoleEnum::ADMIN,
            ],
            [
                'email' => 'manager@gmail.com',
                'name' => 'Manager',
                'username' => 'manager',
                'role' => RoleEnum::MANAGER,
            ],
            [
                'email' => 'user@gmail.com',
                'name' => 'User',
                'username' => 'user',
                'role' => RoleEnum::USER,
            ],
        ];
    }
}
