<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Traits\MultiTenantModelTrait;
use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Task extends Model
{
    use HasFactory, MultiTenantModelTrait;

    protected $fillable = ['target_id', 'name', 'description', 'status', 'priority', 'due_date', 'created_by_id'];

    protected $casts = [
        'status' => TaskStatus::class,
        'priority' => TaskPriority::class
    ];

    protected $appends = ['status_label', 'priority_label'];

    public function getStatusLabelAttribute()
    {
        return $this->status->getLabelText();
    }

    public function getPriorityLabelAttribute()
    {
        return $this->priority->getLabelText();
    }

    protected function dueDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value->toDateString(),
        );
    }

    public function goal(): HasOneThrough
    {
        return $this->hasOneThrough(Goal::class, Target::class, 'id', 'id', 'target_id', 'goal_id');
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(Target::class);
    }
}
