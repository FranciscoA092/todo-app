<?php

use App\Domains\Project\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it lists projects with pagination', function () {
    Project::factory()->count(15)->create();

    $response = $this->getJson(route('projects.index'));

    $response->assertOk();
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'title',
                'description',
                'created_at',
            ],
        ],
        'links' => [
            'first',
            'last',
            'prev',
            'next',
        ],
        'meta' => [
            'current_page',
            'from',
            'last_page',
            'path',
            'per_page',
            'to',
            'total',
        ],
    ]);

    expect($response->json('data'))->toHaveCount(10);
    expect($response->json('meta.per_page'))->toBe(10);
    expect($response->json('meta.total'))->toBe(15);
    expect($response->json('meta.current_page'))->toBe(1);
    expect($response->json('meta.last_page'))->toBe(2);
});

test('it lists the requested page', function () {
    Project::factory()->count(15)->create();

    $response = $this->getJson(route('projects.index', ['page' => 2]));

    $response->assertOk();

    expect($response->json('data'))->toHaveCount(5);
    expect($response->json('meta.current_page'))->toBe(2);
    expect($response->json('meta.per_page'))->toBe(10);
});
