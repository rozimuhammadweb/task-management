<?php

namespace App\Observers;

use App\Models\TaskComment;
use App\Models\TaskHistory;

class TaskCommentObserver
{
    /**
     * Handle the TaskComment "created" event.
     */
    public function created(TaskComment $taskComment): void
    {
        TaskHistory::create([
            'task_id' => $taskComment->task_id,
            'user_id' => auth()->id() ?? $taskComment->user_id,
            'action' => 'comment_added',
            'old_value' => null,
            'new_value' => [
                'comment_id' => $taskComment->id,
                'comment' => $taskComment->comment,
            ],
        ]);
    }

    /**
     * Handle the TaskComment "updated" event.
     */
    public function updated(TaskComment $taskComment): void
    {
        if ($taskComment->isDirty('comment')) {
            TaskHistory::create([
                'task_id' => $taskComment->task_id,
                'user_id' => auth()->id(),
                'action' => 'comment_updated',
                'old_value' => [
                    'comment' => $taskComment->getOriginal('comment')
                ],
                'new_value' => [
                    'comment' => $taskComment->comment
                ],
            ]);
        }
    }

    /**
     * Handle the TaskComment "deleted" event.
     */
    public function deleted(TaskComment $taskComment): void
    {
        TaskHistory::create([
            'task_id' => $taskComment->task_id,
            'user_id' => auth()->id(),
            'action' => 'comment_deleted',
            'old_value' => [
                'comment' => $taskComment->comment
            ],
            'new_value' => null,
        ]);
    }

    /**
     * Handle the TaskComment "restored" event.
     */
    public function restored(TaskComment $taskComment): void
    {
        //
    }

    /**
     * Handle the TaskComment "force deleted" event.
     */
    public function forceDeleted(TaskComment $taskComment): void
    {
        //
    }
}
