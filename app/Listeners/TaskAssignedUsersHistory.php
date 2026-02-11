<?php

namespace App\Listeners;

use App\Events\TaskAssignedUsersChanged;
use App\Models\TaskHistory;

class TaskAssignedUsersHistory
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskAssignedUsersChanged $event): void
    {
        TaskHistory::create([
            'task_id' => $event->task->id,
            'user_id' => auth()->id(),
            'action' => 'assigned_users_changed',
            'old_value' => $event->oldUsers,
            'new_value' => $event->newUsers,
        ]);
    }
}
