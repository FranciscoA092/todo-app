<?php
namespace App\Domains\Project\Actions;

use App\Domains\Project\DTOs\CreateProjectDTO;
use App\Domains\Project\Models\Project;

class CreateProjectAction
{
    public function execute(
        CreateProjectDTO $dto
    ): Project
    {
        return Project::create([
            'title' => $dto->title,
            'description' => $dto->description,
        ]);
    }
}
