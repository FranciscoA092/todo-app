<?php

namespace App\Domains\Task\Actions;

use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DeleteTaskAction
{
    public function execute(Task $task): void
    {
        if ($task->status === TaskStatus::Running) {
            throw new HttpException(Response::HTTP_FORBIDDEN, 'Atividade em andamento não pode ser excluída.');
        }

        $task->delete();
    }
}
