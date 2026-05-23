<?php

use App\Domains\Project\Models\Project;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('it updates a project', function () {
    $project = Project::factory()->create();

    $payload = [
        'title' => fake()->unique()->sentence(3),
        'description' => fake()->paragraph(),
    ];

    $response = $this->putJson(route('projects.update', ['project' => $project->id]), $payload);

    $response->assertOk();
    $response->assertExactJson([
        'message' => 'Projeto atualizado com sucesso',
    ]);

    assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => $payload['title'],
        'description' => $payload['description'],
    ]);
});

test('it validates required fields when updating a project', function () {
    $project = Project::factory()->create();

    $response = $this->putJson(route('projects.update', ['project' => $project->id]), []);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title', 'description']);
});

test('it validates unique title when updating a project', function () {
    $project = Project::factory()->create();
    $anotherProject = Project::factory()->create();

    $response = $this->putJson(route('projects.update', ['project' => $project->id]), [
        'title' => $anotherProject->title,
        'description' => fake()->paragraph(),
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title']);
});

test('it returns not found when trying to update a nonexistent project', function () {
    $response = $this->putJson(route('projects.update', ['project' => 999999]), [
        'title' => fake()->unique()->sentence(3),
        'description' => fake()->paragraph(),
    ]);

    $response->assertNotFound();
});

test('it returns 403 when project has running task while updating', function () {
    $project = Project::factory()->create();

    Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::Running,
    ]);

    $response = $this->putJson(route('projects.update', ['project' => $project->id]), [
        'title' => fake()->unique()->sentence(3),
        'description' => fake()->paragraph(),
    ]);

    $response->assertForbidden();
});

test('it allows update when running task belongs to another project', function () {
    $project = Project::factory()->create();
    $anotherProject = Project::factory()->create();

    Task::factory()->create([
        'project_id' => $anotherProject->id,
        'status' => TaskStatus::Running,
    ]);

    $payload = [
        'title' => fake()->unique()->sentence(3),
        'description' => fake()->paragraph(),
    ];

    $response = $this->putJson(route('projects.update', ['project' => $project->id]), $payload);

    $response->assertOk();
    assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => $payload['title'],
        'description' => $payload['description'],
    ]);
});