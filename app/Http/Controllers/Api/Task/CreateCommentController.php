<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Task\CreateCommentRequest;
use App\Services\Contracts\Task\TaskServiceInterface;

class CreateCommentController extends BaseController
{
    public function __invoke(int|string $taskId, CreateCommentRequest $request, TaskServiceInterface $taskService)
    {
       return $this->createdResponse(
           data: $taskService->addComment($taskId, $request->validated()), // TODO TaskCommenResource with user task relation.
           message: trans('tasks.create_comment_success')
       );
    }
}
