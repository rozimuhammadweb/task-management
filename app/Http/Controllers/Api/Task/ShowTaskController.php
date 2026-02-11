<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Api\BaseController;
use App\Services\Contracts\Task\TaskServiceInterface;

class ShowTaskController extends BaseController
{
    public function __invoke(int|string $id, TaskServiceInterface $taskService)
    {
        return $this->successResponse(data: $taskService->findOrFail($id), message: __('tasks.task_found'));
    }
}
