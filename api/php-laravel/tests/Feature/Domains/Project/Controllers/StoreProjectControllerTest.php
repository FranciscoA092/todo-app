<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('it creates a project', function () {
    $data = [
        'title' => fake()->title(),
        'description' => fake()->paragraph(),
    ];

    $response = $this->postJson(route('projects.store'), $data);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'id',
            'title',
            'description',
            'created_at',
        ]);

    assertDatabaseHas('projects', [
        'title' => $data['title'],
        'description' => $data['description'],
    ]);
});

test('it fails with invalid data', function () {
    $response = $this->postJson(route('projects.store'), [
        'title' => '',
        'description' => '',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['title', 'description']);
});

test('it fails with missing data', function () {
    $response = $this->postJson(route('projects.store'), []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['title', 'description']);
});

test('it fails with non-string data', function () {
    $response = $this->postJson(route('projects.store'), [
        'title' => 123,
        'description' => 456,
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['title', 'description']);
});
