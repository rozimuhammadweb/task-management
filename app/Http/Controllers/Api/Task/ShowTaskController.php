<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Task\ShowTaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Policies\TaskPolicy;
use App\Services\Contracts\Task\TaskServiceInterface;

class ShowTaskController extends BaseController
{
    public function __invoke(ShowTaskRequest $request, int|string $id, TaskServiceInterface $taskService)
    {
        return $this->successResponse(
            data: new TaskResource($taskService->findWithRelations($id)),
            message: __('tasks.task_found')
        );
    }
}
