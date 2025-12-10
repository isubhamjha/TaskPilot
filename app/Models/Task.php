<?php

namespace App\Models;

use App\Http\Resources\TaskResource;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
#[UseResource(TaskResource::class)]
class Task extends BaseModel
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'organization_id',
        'project_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'priority',
        'start_date',
        'due_date',
        'started_at',
        'completed_at',
        'estimate',
        'position',
        'created_by',
        'updated_by',
        'metadata',
        'version',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'estimate' => 'integer',
        'position' => 'integer',
        'metadata' => 'array',
        'version' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

}
