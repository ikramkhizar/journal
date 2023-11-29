<?php

namespace App\Models;

use App\Enums\TargetType;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory, MultiTenantModelTrait;

    protected $fillable = ['goal_id', 'name', 'position', 'type', 'created_by_id'];

    protected $casts = [
        'type' => TargetType::class
    ];

    protected $appends = ['type_label'];

    public function getTypeLabelAttribute()
    {
        return $this->type->getLabelText();
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
