<?php

namespace App\Services;

use App\Repositories\Contracts\Task\TaskRepositoryInterface;
use App\Services\Contracts\Task\TaskServiceInterface;

class TaskService extends BaseService implements TaskServiceInterface
{
    public function __construct(TaskRepositoryInterface $taskService)
    {
        parent::__construct($taskService);
    }

    public function create(array $data)
    {
        $task = $this->repository->create($data);

        if (!empty($data['assigned_users'])) {
            $sync_data = [];
            foreach ($data['assigned_users'] as $user_id) {
                $sync_data[$user_id] = [
                    'assigned_by' => auth()->id(),
                    'assigned_at' => now(),
                ];
            }

            $task->assignedUsers()->sync($sync_data);
        }


        return $task->load('assignedUsers');
    }

    public function update(int|string $id, array $data)
    {
        $assigned_users = $data['assigned_users'] ?? null;
        unset($data['assigned_users']);

        $task = $this->repository->update($id, $data);

        if (!is_null($assigned_users)) {
            $sync_data = [];
            foreach ($assigned_users as $user_id) {
                $sync_data[$user_id] = [
                    'assigned_by' => auth()->id(),
                    'assigned_at' => now(),
                ];
            }

            $task->assignedUsers()->sync($sync_data);
        }

        return $task->load('assignedUsers');
    }
}
