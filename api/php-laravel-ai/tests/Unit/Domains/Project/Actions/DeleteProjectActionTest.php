<?php

use App\Domains\Project\Actions\DeleteProjectAction;
use App\Domains\Project\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Laravel\assertDatabaseMissing;

uses(TestCase::class, RefreshDatabase::class);

test('it deletes a project', function () {
    $project = Project::factory()->create();

    (new DeleteProjectAction())->execute($project);

    assertDatabaseMissing('projects', [
        'id' => $project->id,
    ]);
});