<?php

use App\Domains\Project\Models\Project;
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
