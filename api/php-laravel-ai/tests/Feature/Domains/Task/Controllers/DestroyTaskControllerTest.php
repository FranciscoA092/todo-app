<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

test('it deletes a task successfully', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Pending,
    ]);

    $response = $this->deleteJson(route('projects.tasks.destroy', ['project' => $project->id, 'task' => $task->id]));

    $response->assertOk();
    $response->assertJson(['message' => 'Atividade excluida com sucesso']);

    assertDatabaseMissing('tasks', ['id' => $task->id]);
});

test('it returns 403 when task status is running on delete', function () {
    $project = Project::factory()->create();
    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Running,
    ]);

    $response = $this->deleteJson(route('projects.tasks.destroy', ['project' => $project->id, 'task' => $task->id]));

    $response->assertForbidden();

    assertDatabaseMissing('tasks', ['id' => null]);
    expect(Task::find($task->id))->not->toBeNull();
});

test('it returns not found when project does not exist on delete', function () {
    $task = Task::factory()->create();

    $response = $this->deleteJson(route('projects.tasks.destroy', ['project' => 999999, 'task' => $task->id]));

    $response->assertNotFound();
});

test('it returns not found when task does not exist on delete', function () {
    $project = Project::factory()->create();

    $response = $this->deleteJson(route('projects.tasks.destroy', ['project' => $project->id, 'task' => 999999]));

    $response->assertNotFound();
});
