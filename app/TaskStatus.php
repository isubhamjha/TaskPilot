<?php

namespace App;

enum TaskStatus: string
{
     case CREATED = 'created';
     case IN_PROGRESS = 'in_progress';
     case COMPLETED = 'completed';
     case CANCELLED = 'cancelled';

    /**
     * @return string
     */
    public function labels(): string
    {
        return match ($this) {
            self::CREATED => __('Created'),
            self::IN_PROGRESS => __('In Progress'),
            self::COMPLETED => __('Completed'),
            self::CANCELLED => __('Cancelled')
        };
    }
}
