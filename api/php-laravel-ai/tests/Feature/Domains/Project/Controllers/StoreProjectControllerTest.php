<?php

use App\Domains\Project\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('it creates a project', function () {
    $payload = [
        'title' => fake()->unique()->sentence(3),
        'description' => fake()->paragraph(),
    ];

    $response = $this->postJson(route('projects.store'), $payload);

    $response->assertCreated();
    $response->assertJson([
        'title' => $payload['title'],
        'description' => $payload['description'],
    ]);
    $response->assertJsonStructure([
        'id',
        'title',
        'description',
        'created_at',
    ]);

    assertDatabaseHas('projects', $payload);
});

test('it validates required fields', function () {
    $response = $this->postJson(route('projects.store'), [
        'description' => fake()->paragraph(),
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title']);
});

test('it validates unique title', function () {
    $project = Project::factory()->create();

    $response = $this->postJson(route('projects.store'), [
        'title' => $project->title,
        'description' => fake()->paragraph(),
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title']);
});
