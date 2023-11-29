<?php

namespace App\Models;

use Attribute;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Goal extends Model
{
    use HasFactory, MultiTenantModelTrait;

    protected $fillable = ['name', 'description', 'start_date', 'due_date', 'created_by_id'];

    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value->toDateString(),
        );
    }

    protected function dueDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value->toDateString(),
        );
    }

    public function targets(): HasMany
    {
        return $this->hasMany(Target::class);
    }

    public function tasks(): HasOneThrough
    {
        return $this->hasOneThrough(Task::class, Target::class);
    }
}
