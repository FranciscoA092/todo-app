<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\DeleteTaskAction;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

use function Pest\Laravel\assertDatabaseMissing;

uses(TestCase::class, RefreshDatabase::class);

test('it deletes a task', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Pending,
    ]);

    (new DeleteTaskAction())->execute($task);

    assertDatabaseMissing('tasks', ['id' => $task->id]);
});

test('it throws 403 when task status is running', function () {
    $task = Task::factory()->create(['status' => TaskStatus::Running]);

    expect(fn () => (new DeleteTaskAction())->execute($task))
        ->toThrow(HttpException::class);

    expect(Task::find($task->id))->not->toBeNull();
});
