<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Policies\Base\BasePolicy;

class UserPolicy extends BasePolicy
{
    const VIEW_ANY = 'view-any-users';
    const VIEW = 'view-user';
    const CREATE = 'create-user';
    const UPDATE = 'update-user';
    const DELETE = 'delete-user';
    const CHANGE_ROLE = 'change-user-role';
    const CHANGE_STATUS = 'change-user-status';

    public static function getRolePermissions(): array
    {
        return [
            RoleEnum::ADMIN->value => [
                self::VIEW_ANY,
                self::VIEW,
                self::CREATE,
                self::UPDATE,
                self::DELETE,
                self::CHANGE_ROLE,
                self::CHANGE_STATUS,
            ],
        ];
    }

    public function viewAnyUsers(User $user): bool
    {
        return $user->hasPermissionTo(self::VIEW_ANY);
    }

    public function viewUser(User $user, User $target): bool
    {
        if (!$user->hasPermissionTo(self::VIEW)) return false;

        if ($user->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::MANAGER->value])) {
            return true;
        }

        return $user->id === $target->id;
    }

    public function createUser(User $user): bool
    {
        return $user->hasPermissionTo(self::CREATE);
    }

    public function updateUser(User $user, User $target): bool
    {
        if (!$user->hasPermissionTo(self::UPDATE)) {
            return false;
        }

        if ($user->hasRole(RoleEnum::ADMIN->value)) {
            return true;
        }

        return $user->id === $target->id;
    }

    public function deleteUser(User $user, User $target): bool
    {
        return $user->hasPermissionTo(self::DELETE) && $user->id !== $target->id;
    }

    public function changeUserRole(User $user, User $target): bool
    {
        return $user->hasPermissionTo(self::CHANGE_ROLE) && $user->id !== $target->id;
    }

    public function changeUserStatus(User $user, User $target): bool
    {
        return $user->hasPermissionTo(self::CHANGE_STATUS) && $user->id !== $target->id;
    }
}
