<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description ? substr($this->description, 0, 50) . '...' : '',
            'start_date' => $this->start_date->toDateString(),
            'due_date' => $this->due_date->toDateString(),
        ];
    }
}
