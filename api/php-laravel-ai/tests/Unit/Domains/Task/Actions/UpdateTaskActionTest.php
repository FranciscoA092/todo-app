<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Actions\UpdateTaskAction;
use App\Domains\Task\DTOs\UpdateTaskDTO;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

use function Pest\Laravel\assertDatabaseHas;

uses(TestCase::class, RefreshDatabase::class);

test('it updates a task with new data', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Pending,
    ]);

    $updated = (new UpdateTaskAction())->execute(
        new UpdateTaskDTO(
            title: 'Novo título',
            description: 'Nova descrição',
            status: TaskStatus::Completed,
        ),
        $task,
    );

    expect($updated->title)->toBe('Novo título');
    expect($updated->description)->toBe('Nova descrição');
    expect($updated->status)->toBe(TaskStatus::Completed);

    assertDatabaseHas('tasks', [
        'id' => $task->id,
        'title' => 'Novo título',
        'description' => 'Nova descrição',
        'status' => TaskStatus::Completed->value,
    ]);
});

test('it throws 403 when task status is running', function () {
    $task = Task::factory()->create(['status' => TaskStatus::Running]);

    expect(fn () => (new UpdateTaskAction())->execute(
        new UpdateTaskDTO(
            title: 'Tentativa',
            description: null,
            status: TaskStatus::Completed,
        ),
        $task,
    ))->toThrow(HttpException::class);
});
