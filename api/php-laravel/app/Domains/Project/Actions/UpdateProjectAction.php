<?php
namespace App\Domains\Project\Actions;

use App\Domains\Project\DTOs\UpdateProjectDTO;
use App\Domains\Project\Models\Project;

class UpdateProjectAction
{
    public function execute(
        UpdateProjectDTO $dto,
        int $projectId
    ): Project
    {
        $project = Project::findOrFail($projectId);
        $project->update([
            'title' => $dto->title,
            'description' => $dto->description ?? $project->description,
        ]);

        return $project;
    }
}
