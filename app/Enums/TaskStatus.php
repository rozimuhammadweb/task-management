<?php

namespace App\Enums;

enum TaskStatus: string
{
    case WAITING = 'waiting';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';

    public function label(): string
    {
        return match ($this) {
            self::WAITING => __('Waiting'),
            self::IN_PROGRESS => __('In Progress'),
            self::DONE => __('Done'),
        };
    }
}
