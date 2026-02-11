<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\TaskHistory;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        TaskHistory::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'action' => 'created',
            'old_value' => null,
            'new_value' => $task->toArray(),
        ]);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $changes = $task->getChanges();
        $original = $task->getOriginal();

        $old = [];
        $new = [];

        foreach ($changes as $key => $value) {
            if (in_array($key, ['updated_at'])) continue;

            $old[$key] = $original[$key] ?? null;
            $new[$key] = $value;
        }

        if (!empty($old)) {
            TaskHistory::create([
                'task_id' => $task->id,
                'user_id' => auth()->id(),
                'action' => 'updated',
                'old_value' => $old,
                'new_value' => $new,
            ]);
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        TaskHistory::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'old_value' => $task->toArray(),
            'new_value' => null,
        ]);
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
