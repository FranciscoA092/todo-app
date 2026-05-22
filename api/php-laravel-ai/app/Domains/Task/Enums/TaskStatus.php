<?php

namespace App\Domains\Task\Enums;

enum TaskStatus: string
{
    case Pending = 'pending';
    case Running = 'running';
    case Completed = 'completed';
}