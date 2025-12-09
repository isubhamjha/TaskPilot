<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends BaseModel
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'project_id',
        'assigned_to',

        'title',
        'description',

        'status',
        'priority',

        'start_date',
        'due_date',
        'estimated_hours',

        'metadata',
        'version',

    ];

    protected $casts = [
        'metadata' => 'array',
    ];

}
