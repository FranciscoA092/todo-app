<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\CreateTaskAction;
use App\Domains\Task\DTOs\CreateTaskDTO;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Laravel\assertDatabaseHas;

uses(TestCase::class, RefreshDatabase::class);

test('it creates a task with pending status associated to a project', function () {
    $project = Project::factory()->create();

    $task = (new CreateTaskAction())->execute(
        new CreateTaskDTO(
            title: 'Nova atividade',
            description: null,
        ),
        $project,
    );

    expect($task)->toBeInstanceOf(Task::class);
    expect($task->status)->toBe(TaskStatus::Pending);
    expect($task->project_id)->toBe($project->id);

    assertDatabaseHas('tasks', [
        'id' => $task->id,
        'title' => 'Nova atividade',
        'description' => null,
        'status' => TaskStatus::Pending->value,
        'project_id' => $project->id,
    ]);
});
