<?php

namespace App;

enum MembershipStatus: string
{
    // pending, accepted, declined
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case DECLINED = 'declined';

    public function label(): array|string|null{
        return match ($this) {
            MembershipStatus::PENDING => __('Pending'),
            MembershipStatus::ACCEPTED => __('Accepted'),
            MembershipStatus::DECLINED => __('Declined'),
        };
    }
}
