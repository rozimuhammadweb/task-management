<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Task;
use App\Models\User;
use App\Policies\Base\BasePolicy;

class TaskPolicy extends BasePolicy
{
    const VIEW_ANY = 'view-any-tasks';
    const VIEW = 'view-task';
    const CREATE = 'create-task';
    const UPDATE = 'update-task';
    const DELETE = 'delete-task';
    const ASSIGN = 'assign-user-task';
    const UPDATE_STATUS = 'update-status-task';
    const COMMENT = 'create-comment';
    const VIEW_HISTORY = 'view-history-task';

    public static function getRolePermissions(): array
    {
        return [
            RoleEnum::ADMIN->value => [
                self::VIEW_ANY,
                self::VIEW,
                self::CREATE,
                self::UPDATE,
                self::DELETE,
                self::ASSIGN,
                self::UPDATE_STATUS,
                self::COMMENT,
                self::VIEW_HISTORY,
            ],
            RoleEnum::MANAGER->value => [
                self::VIEW_ANY,
                self::VIEW,
                self::CREATE,
                self::UPDATE,
                self::DELETE,
                self::ASSIGN,
                self::UPDATE_STATUS,
                self::COMMENT,
            ],
            RoleEnum::USER->value => [
                self::VIEW,
                self::UPDATE_STATUS,
                self::COMMENT,
            ],
        ];
    }

    public function viewAnyTasks(User $user): bool
    {
        if ($user->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::MANAGER->value])) {
            return true;
        }

        return $user->hasRole(RoleEnum::USER->value);
    }

    public function viewTask(User $user, Task $task): bool
    {
        if ($user->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::MANAGER->value])) {
            return true;
        }

        return $task->assignedUsers->contains('id', $user->id);
    }


    public function createTask(User $user): bool
    {
        return $user->hasPermissionTo(self::CREATE);
    }

    public function updateTask(User $user, Task $task): bool
    {
        return $user->hasPermissionTo(self::UPDATE);
    }

    public function deleteTask(User $user, Task $task): bool
    {
        return $user->hasPermissionTo(self::DELETE);
    }

    public function assignUserTask(User $user, Task $task): bool
    {
        return $user->hasPermissionTo(self::ASSIGN);
    }

    public function updateStatusTask(User $user, Task $task): bool
    {
        if (!$user->hasPermissionTo(self::UPDATE_STATUS)) {
            return false;
        }

        if ($user->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::MANAGER->value])) {
            return true;
        }

        return $task->assignedUsers->contains('id', $user->id);
    }

    public function createComment(User $user, Task $task): bool
    {
        if (!$user->hasPermissionTo(self::COMMENT)) {
            return false;
        }

        if ($user->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::MANAGER->value])) {
            return true;
        }

        return $task->assignedUsers->contains('id', $user->id);
    }

    public function viewTaskHistory(User $user, Task $task): bool
    {
        return $user->hasPermissionTo(self::VIEW_HISTORY);
    }
}
