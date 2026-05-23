<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

test('it deletes a project', function () {
    $project = Project::factory()->create();

    $response = $this->deleteJson(route('projects.destroy', ['project' => $project->id]));

    $response->assertOk();
    $response->assertExactJson([
        'message' => 'Projeto excluido com sucesso',
    ]);

    assertDatabaseMissing('projects', [
        'id' => $project->id,
    ]);
});

test('it returns not found when trying to delete a nonexistent project', function () {
    $response = $this->deleteJson(route('projects.destroy', ['project' => 999999]));

    $response->assertNotFound();
});

test('it returns 403 when project has running task while deleting', function () {
    $project = Project::factory()->create();

    Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Running,
    ]);

    $response = $this->deleteJson(route('projects.destroy', ['project' => $project->id]));

    $response->assertForbidden();
});

test('it allows delete when running task belongs to another project', function () {
    $project = Project::factory()->create();
    $anotherProject = Project::factory()->create();

    Task::factory()->create([
        'project_id' => $anotherProject->id,
        'status' => TaskStatus::Running,
    ]);

    $response = $this->deleteJson(route('projects.destroy', ['project' => $project->id]));

    $response->assertOk();

    assertDatabaseMissing('projects', [
        'id' => $project->id,
    ]);
});
