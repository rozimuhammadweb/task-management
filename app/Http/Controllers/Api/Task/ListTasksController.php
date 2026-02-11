<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\ListTasksRequest;
use App\Services\Contracts\Task\TaskServiceInterface;

class ListTasksController extends BaseController
{
    public function __invoke(ListTasksRequest $request, TaskServiceInterface $taskService)
    {
        return $this->successResponse(data: $taskService->list($request->validated()), message: __('tasks.list.success'));
    }

    // TODO: Implement __invoke() method.
}
