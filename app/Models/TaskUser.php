<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskUser extends BaseModel
{
    /** @use HasFactory<\Database\Factories\TaskUserFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'phone',
        'profile',
        'settings',
        'last_active_at',
    ];

    protected $casts = [
        'profile' => 'array',
        'settings' => 'array',
        'last_active_at' => 'datetime',
    ];
}
