<?php

namespace App\Domains\Project\Actions;

use App\Domains\Project\Models\Project;
use App\Domains\Task\Enums\TaskStatus;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DeleteProjectAction
{
    public function execute(Project $project): void
    {
        if ($project->tasks()->where('status', TaskStatus::Running->value)->exists()) {
            throw new HttpException(Response::HTTP_FORBIDDEN, 'Projeto possui atividade em execução.');
        }

        $project->delete();
    }
}