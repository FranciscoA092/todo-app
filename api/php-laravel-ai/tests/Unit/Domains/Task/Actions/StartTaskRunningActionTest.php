<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\StartTaskRunningAction;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Runner;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

use function Pest\Laravel\assertDatabaseHas;

uses(TestCase::class, RefreshDatabase::class);

test('it starts execution and updates task status to running', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Pending,
    ]);

    $updated = (new StartTaskRunningAction())->execute($task);

    expect($updated->status)->toBe(TaskStatus::Running);

    assertDatabaseHas('runners', [
        'task_id' => $task->id,
        'stop_at' => null,
    ]);
});

test('it throws 403 when task status is already running', function () {
    $task = Task::factory()->create(['status' => TaskStatus::Running]);

    expect(fn () => (new StartTaskRunningAction())->execute($task))
        ->toThrow(HttpException::class);
});

test('it throws 403 when task has an open runner', function () {
    $task = Task::factory()->create(['status' => TaskStatus::Pending]);

    Runner::factory()->create([
        'task_id' => $task->id,
        'stop_at' => null,
    ]);

    expect(fn () => (new StartTaskRunningAction())->execute($task))
        ->toThrow(HttpException::class);
});
