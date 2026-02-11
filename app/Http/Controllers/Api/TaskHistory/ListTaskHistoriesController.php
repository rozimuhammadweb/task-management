<?php

namespace App\Http\Controllers\Api\TaskHistory;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\TaskHistory\ListTaskHistoriesRequest;
use App\Services\Contracts\TaskHistory\TaskHistoryServiceInterface;

class ListTaskHistoriesController extends BaseController
{
    public function __invoke(ListTaskHistoriesRequest $request, TaskHistoryServiceInterface $taskService)
    {
        return $this->successResponse(data: $taskService->list($request->validated()), message: __('task-histories.list.success'));
    }
}
