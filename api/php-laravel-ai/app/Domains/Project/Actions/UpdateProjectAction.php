<?php

namespace App\Domains\Project\Actions;

use App\Domains\Project\DTOs\UpdateProjectDTO;
use App\Domains\Project\Models\Project;

class UpdateProjectAction
{
    public function execute(UpdateProjectDTO $dto, Project $project): Project
    {
        $project->update([
            'title' => $dto->title,
            'description' => $dto->description,
        ]);

        return $project->refresh();
    }
}