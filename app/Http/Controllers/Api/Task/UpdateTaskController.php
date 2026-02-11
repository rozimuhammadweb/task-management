<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Services\Contracts\Task\TaskServiceInterface;

class UpdateTaskController extends BaseController
{
    public function __invoke(int|string $id, UpdateTaskRequest $request, TaskServiceInterface $taskService)
    {
        return $this->successResponse(data: $taskService->update($id, $request->validated()), message: __('tasks.update.success'));
    }
}
