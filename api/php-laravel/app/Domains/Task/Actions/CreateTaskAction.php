<?php
namespace App\Domains\Task\Actions;

use App\Domains\Project\Models\Project;
use App\Domains\Task\DTOs\CreateTaskDTO;
use App\Domains\Task\Models\Task;

class CreateTaskAction
{
    public function execute(
        CreateTaskDTO $data,
        Project $project
    ): Task
    {
        $task = new Task();
        $task->title = $data->title;
        $task->description = $data->description;
        $task->project()->associate($project);
        $task->save();

        return $task;
    }
}
