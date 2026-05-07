<?php

use App\Domains\Project\Models\Project;

beforeEach(function () {
    test()->project = Project::factory()->create();
});

test('it creates a task', function () {

    $response = $this->postJson(route('tasks.store', ['project_id' => test()->project->id]), [
        'title' => 'Test Task',
        'description' => 'This is a test task.',
    ]);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'id',
        'title',
        'description',
        'created_at',
        'project_id',
    ]);
});

test('it validates the request', function () {

    $response = $this->postJson(route('tasks.store', ['project_id' => test()->project->id]), [
        'description' => 'This is a test task without a title.',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title']);
});

test('it returns 404 if project not found', function () {

    $response = $this->postJson(route('tasks.store', ['project_id' => 999]), [
        'title' => 'Test Task',
        'description' => 'This is a test task.',
    ]);

    $response->assertStatus(404);
});
