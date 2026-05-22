<?php

namespace Database\Factories;

use App\Domains\Task\Models\Runner;
use App\Domains\Task\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Runner>
 */
class RunnerFactory extends Factory
{
    protected $model = Runner::class;

    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_id' => Task::factory(),
            'start_at' => now(),
            'stop_at' => null,
        ];
    }
}
