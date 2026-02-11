<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Contracts\Task\TaskRepositoryInterface;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }
}
