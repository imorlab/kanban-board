<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $statuses = TaskStatus::cases();

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->optional(0.7)->paragraph(),
            'status' => fake()->randomElement($statuses)->value,
            'sort_order' => fake()->numberBetween(0, 100),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Create a task with pending status.
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => TaskStatus::PENDING->value,
            ];
        });
    }

    /**
     * Create a task with in progress status.
     */
    public function inProgress()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => TaskStatus::IN_PROGRESS->value,
            ];
        });
    }

    /**
     * Create a task with completed status.
     */
    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => TaskStatus::COMPLETED->value,
            ];
        });
    }
}
