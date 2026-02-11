<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Services\Contracts\Task\TaskServiceInterface;

class CreateTaskController extends BaseController
{
    public function __invoke(CreateTaskRequest $request, TaskServiceInterface $taskService)
    {
        return $this->createdResponse(data: $taskService->create($request->validated()), message: __('tasks.create.success'));
    }
}
