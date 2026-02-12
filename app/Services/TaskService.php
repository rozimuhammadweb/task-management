<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Events\TaskAssignedUsersChanged;
use App\Repositories\Contracts\Task\TaskRepositoryInterface;
use App\Services\Contracts\Task\TaskServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService extends BaseService implements TaskServiceInterface
{
    protected array $filterFields = [
        'title' => ['type' => 'string_search'],
        'status' => ['type' => 'string'],
    ];

    protected array $selectFields = [
        'id',
        'title',
        'status',
        'created_by',
        'deadline',
    ];

    protected array $relations = [
        'assignedUsers',
        'creator'
    ];

    public function __construct(TaskRepositoryInterface $taskService)
    {
        parent::__construct($taskService);
    }

    public function get(array $params, bool $pagination = true): LengthAwarePaginator
    {
        $query = $this->repository->query();
        $query = $this->applyFilters($query, $params);
        $query = $this->applySelect($query);
        $query = $this->applyRelations($query);
        $user = auth()->user();

        if ($user->hasRole(RoleEnum::USER->value)) {
            $query->forUser($user->id);
        }

        return $query->paginate($params['per_page'] ?? 20);
    }

    public function findWithRelations(int|string $id)
    {
        return $this->repository->query()->with([
                'assignedUsers',
                'creator',
                'comments.user',
                'histories.user',
            ])->findOrFail($id);
    }

    public function create(array $data)
    {
        $task = $this->repository->create($data);

        $oldUsers = [];
        $newUsers = $this->syncAssignedUsers($task, $data['assigned_users'] ?? []);
        $this->dispatchAssignedUsersEvent($task, $oldUsers, $newUsers);

        return $task;
    }

    public function update(int|string $id, array $data)
    {
        $task = $this->repository->findOrFail($id);

        $oldUsers = $task->assignedUsers()->pluck('users.id')->toArray();
        $task = $this->repository->update($id, $data);
        $newUsers = $this->syncAssignedUsers($task, $data['assigned_users'] ?? []);

        if ($oldUsers !== $newUsers) {
            $this->dispatchAssignedUsersEvent($task, $oldUsers, $newUsers);
        }

        return $task;
    }

    public function addComment(int|string $taskId, array $data)
    {
        $task = $this->repository->findOrFail($taskId);
        return $task->comments()->create($data);
    }

    private function syncAssignedUsers($task, array $userIds): array
    {
        if (empty($userIds)) {
            return [];
        }

        $syncData = collect($userIds)->mapWithKeys(fn ($userId) => [
            $userId => [
                'assigned_by' => auth()->id(),
                'assigned_at' => now(),
            ],
        ])->toArray();

        $task->assignedUsers()->sync($syncData);

        return $task->assignedUsers()->pluck('users.id')->toArray();
    }

    private function dispatchAssignedUsersEvent($task, array $oldUsers, array $newUsers): void
    {
        event(new TaskAssignedUsersChanged($task, $oldUsers, $newUsers));
    }
}
