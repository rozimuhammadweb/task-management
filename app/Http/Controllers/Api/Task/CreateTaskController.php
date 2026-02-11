<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Services\Contracts\Task\TaskServiceInterface;

class CreateTaskController extends BaseController
{
    public function __invoke(CreateTaskRequest $request, TaskServiceInterface $taskService)
    {
        return $this->createdResponse(
            data: new TaskResource($taskService->create($request->validated())),
            message: __('tasks.create.success')
        );
    }
}
