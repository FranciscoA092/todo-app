<?php

namespace Database\Factories;

use App\Domains\Project\Models\Project;
use App\Domains\Task\Enum\StatusTask;
use App\Domains\Task\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => StatusTask::PENDING->value,
            'project_id' => Project::factory(),
        ];
    }

    /**
     * Indicate that the task is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => StatusTask::PENDING->value,
        ]);
    }

    /**
     * Indicate that the task is running.
     */
    public function running(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => StatusTask::RUNNING->value,
        ]);
    }

    /**
     * Indicate that the task is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => StatusTask::COMPLETED->value,
        ]);
    }
}
