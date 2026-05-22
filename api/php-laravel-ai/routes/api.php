<?php

use App\Domains\Project\Controllers\IndexProjectController;
use App\Domains\Project\Controllers\DestroyProjectController;
use App\Domains\Project\Controllers\StoreProjectController;
use App\Domains\Project\Controllers\UpdateProjectController;
use App\Domains\Task\Controllers\DestroyTaskController;
use App\Domains\Task\Controllers\IndexTaskController;
use App\Domains\Task\Controllers\StartTaskRunningController;
use App\Domains\Task\Controllers\StopTaskRunningController;
use App\Domains\Task\Controllers\StoreTaskController;
use App\Domains\Task\Controllers\UpdateTaskController;
use Illuminate\Support\Facades\Route;

Route::get('/projects', IndexProjectController::class)
    ->name('projects.index');

Route::post('/projects', StoreProjectController::class)
    ->name('projects.store');

Route::put('/projects/{project}', UpdateProjectController::class)
    ->name('projects.update');

Route::delete('/projects/{project}', DestroyProjectController::class)
    ->name('projects.destroy');

Route::post('/projects/{project}/tasks', StoreTaskController::class)
    ->name('projects.tasks.store');

Route::get('/projects/{project}/tasks', IndexTaskController::class)
    ->name('projects.tasks.index');

Route::put('/projects/{project}/tasks/{task}', UpdateTaskController::class)
    ->name('projects.tasks.update');

Route::delete('/projects/{project}/tasks/{task}', DestroyTaskController::class)
    ->name('projects.tasks.destroy');

Route::post('/projects/{project}/tasks/{task}/start', StartTaskRunningController::class)
    ->name('projects.tasks.start');

Route::post('/projects/{project}/tasks/{task}/stop', StopTaskRunningController::class)
    ->name('projects.tasks.stop');
