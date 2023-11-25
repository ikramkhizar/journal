<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goal>
 */
class GoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(500),
            'start_date' => fake()->dateTimeThisMonth(),
            'due_date' => fake()->dateTimeThisMonth(),
            'created_by_id' => User::where('id', '!=', 1)->get()->random()->id
        ];
    }
}
