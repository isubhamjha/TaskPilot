<?php

namespace App;

enum SubscriptionStatus: string
{
    case ACTIVE = 'active';
    case PAST_DUE = 'past_due';
    case CANCELLED = 'cancelled';
    case TRAILING = 'trailing';

    public function label(): array|string|null{
        return match ($this) {
            self::ACTIVE => __('Active'),
            self::PAST_DUE => __('Past Due'),
            self::CANCELLED => __('Cancelled'),
            self::TRAILING => __('Trailing'),
        };
    }
}
