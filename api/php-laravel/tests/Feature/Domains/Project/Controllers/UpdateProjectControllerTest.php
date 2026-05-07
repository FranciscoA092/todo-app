<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('it updates a project', function () {
    $project = \App\Domains\Project\Models\Project::factory()->create();

    $response = $this->putJson(route('projects.update', ['id' => $project->id]), [
        'title' => 'Updated Title',
        'description' => 'Updated Description',
    ]);

    $response->assertStatus(200)
        ->assertJsonFragment([
            'id' => $project->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);

    assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => 'Updated Title',
        'description' => 'Updated Description',
    ]);
});

test('it returns validation errors when updating a project with invalid data', function () {
    $project = \App\Domains\Project\Models\Project::factory()->create();

    $response = $this->putJson(route('projects.update', ['id' => $project->id]), [
        'title' => '', // Invalid title
        'description' => '', // Invalid description
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['title', 'description']);
});

test('it returns a 404 error when trying to update a non-existent project', function () {
    $response = $this->putJson(route('projects.update', ['id' => 999]), [
        'title' => 'Updated Title',
        'description' => 'Updated Description',
    ]);

    $response->assertStatus(404);
});
