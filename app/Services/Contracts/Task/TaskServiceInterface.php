<?php

namespace App\Services\Contracts\Task;

use App\Http\Requests\Task\CreateCommentRequest;
use App\Services\Contracts\BaseServiceInterface;

interface TaskServiceInterface extends BaseServiceInterface
{
    public function addComment(int|string $taskId, array $data);

    public function findWithRelations(int|string $id);
}
