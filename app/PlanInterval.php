<?php

namespace App;

enum PlanInterval: string
{
    case MONTHLY = 'monthly';
    case WEEKLY = 'weekly';
    case DAILY = 'daily';
    case YEARLY = 'yearly';

    public function label(): array|string|null{
        return match ($this) {
            self::MONTHLY => __('Monthly'),
            self::WEEKLY => __('Weekly'),
            self::DAILY => __('Daily'),
            self::YEARLY => __('Yearly'),
        };
    }
}
