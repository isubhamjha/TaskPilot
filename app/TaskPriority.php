<?php

namespace App;

enum TaskPriority: string
{
    case LOW = 'low';
    case HIGH = 'high';
    case NORMAL = 'normal';

    public  function label(): array|string|null
    {
        return match($this) {
            TaskPriority::LOW => __('Low'),
            TaskPriority::HIGH => __('High'),
            TaskPriority::NORMAL => __('Normal'),
        };
    }
}
