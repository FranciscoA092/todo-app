<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\StopTaskRunningAction;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Runner;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('it stops running execution and sets task to pending', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Running,
    ]);

    $runner = Runner::factory()->create([
        'task_id' => $task->id,
        'stop_at' => null,
    ]);

    $updatedTask = (new StopTaskRunningAction())->execute($task);

    expect($updatedTask->status)->toBe(TaskStatus::Pending);
    expect($runner->fresh()->stop_at)->not->toBeNull();
});

test('it throws 400 when latest runner is already closed', function () {
    $task = Task::factory()->create([
        'status' => TaskStatus::Running,
    ]);

    Runner::factory()->create([
        'task_id' => $task->id,
        'stop_at' => now(),
    ]);

    expect(fn () => (new StopTaskRunningAction())->execute($task))
        ->toThrow(HttpException::class);
});

test('it throws 400 when there is no runner', function () {
    $task = Task::factory()->create([
        'status' => TaskStatus::Running,
    ]);

    expect(fn () => (new StopTaskRunningAction())->execute($task))
        ->toThrow(HttpException::class);
});
