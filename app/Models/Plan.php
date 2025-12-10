<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends BaseModel
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'provider_plan_id',
        'price',
        'currency',
        'interval',
        'limits',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'limits' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
