<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends BaseModel
{
    /** @use HasFactory<\Database\Factories\NotificationFactory> */
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'user_id',
        'type',
        'payload',
        'read_at',
        'is_archived',
    ];

    protected $casts = [
        'payload' => 'array',
        'read_at' => 'datetime',
        'is_archived' => 'boolean',
    ];
}
