<?php

namespace App\Repositories;

use App\Models\TaskHistory;
use App\Repositories\Contracts\TaskHistory\TaskHistoryRepositoryInterface;

class TaskHistoryRepository extends BaseRepository implements TaskHistoryRepositoryInterface
{
    public function __construct(TaskHistory $model)
    {
        parent::__construct($model);
    }
}
