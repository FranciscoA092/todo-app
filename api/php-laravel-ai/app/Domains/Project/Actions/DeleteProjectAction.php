<?php

namespace App\Domains\Project\Actions;

use App\Domains\Project\Models\Project;

class DeleteProjectAction
{
    public function execute(Project $project): void
    {
        $project->delete();
    }
}