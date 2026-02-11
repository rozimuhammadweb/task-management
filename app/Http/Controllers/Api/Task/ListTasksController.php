<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Task\ListTasksRequest;
use App\Http\Resources\Task\TaskCollection;
use App\Services\Contracts\Task\TaskServiceInterface;

class ListTasksController extends BaseController
{
    public function __invoke(ListTasksRequest $request, TaskServiceInterface $taskService)
    {
        return $this->successResponse(
            data: new TaskCollection($taskService->get($request->validated())),
            message: __('tasks.list.success')
        );
    }
}
