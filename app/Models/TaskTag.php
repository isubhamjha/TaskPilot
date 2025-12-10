<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTag extends BaseModel
{
    /** @use HasFactory<\Database\Factories\TaskTagFactory> */
    use HasFactory;

    protected $fillable = [
        'task_id',
        'tag_id',
        'organization_id',
    ];
}
