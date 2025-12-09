<?php

namespace App;

enum MembershipRole: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case MEMBER = 'member';
    public  function label(): array|string|null
    {
        return match ($this) {
            MembershipRole::ADMIN => __('Admin'),
            MembershipRole::MANAGER => __('Manager'),
            MembershipRole::MEMBER => __('Member'),
        };
    }

}
