<?php

namespace App\Domains\Task\Actions;

use App\Domains\Task\Enums\TaskStatus;
use App\Domains\Task\Models\Task;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StopTaskRunningAction
{
    public function execute(Task $task): Task
    {
        $runner = $task->runners()->latest('id')->first();

        if ($runner === null || $runner->stop_at !== null) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, 'Execução em aberto não encontrada.');
        }

        DB::transaction(function () use ($task, $runner): void {
            $runner->update([
                'stop_at' => now(),
            ]);

            $task->update([
                'status' => TaskStatus::Pending,
            ]);
        });

        return $task->fresh();
    }
}
