<?php

namespace App\Services;

use App\Repositories\Contracts\TaskHistory\TaskHistoryRepositoryInterface;
use App\Services\Contracts\TaskHistory\TaskHistoryServiceInterface;

class TaskHistoryService extends BaseService implements TaskHistoryServiceInterface
{
    public function __construct(TaskHistoryRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
