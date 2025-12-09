<?php

namespace App;

enum InvoiceStatus: string
{
    case PAID = 'paid';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';
    case FAILED = 'failed';

    public function label(): array|string|null{
        return match ($this) {
            self::PAID => __('Paid'),
            self::PENDING => __('Pending'),
            self::REJECTED => __('Rejected'),
            self::CANCELLED => __('Cancelled'),
            self::FAILED => __('Failed'),

        };
    }
}
