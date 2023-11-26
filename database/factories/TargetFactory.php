<?php

namespace Database\Factories;

use App\Models\Goal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Target>
 */
class TargetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $goal = Goal::all()->random();

        return [
            'goal_id' => $goal->id,
            'name' => fake()->name(),
            'position' => random_int(1, 500),
            'type' => fake()->randomElement(['boolean', 'number', 'tasks', 'currency']),
            'created_by_id' => $goal->created_by_id
        ];
    }
}
