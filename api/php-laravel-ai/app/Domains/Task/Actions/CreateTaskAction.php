<?php

namespace App\Domains\Task\Actions;

use App\Domains\Project\Models\Project;
use App\Domains\Task\DTOs\CreateTaskDTO;
use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;

class CreateTaskAction
{
    public function execute(CreateTaskDTO $dto, Project $project): Task
    {
        return Task::query()->create([
            'title' => $dto->title,
            'description' => $dto->description,
            'status' => TaskStatus::Pending,
            'project_id' => $project->id,
        ]);
    }
}
