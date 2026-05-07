<?php

use App\Domains\Project\Controllers\StoreProjectController;
use App\Domains\Project\Controllers\UpdateProjectController;
use App\Domains\Task\Controllers\IndexTaskController;
use App\Domains\Task\Controllers\StoreTaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('projects')
    ->group(function () {

        Route::post('/', StoreProjectController::class)
            ->name('projects.store');

        Route::prefix('{project_id}')
            ->group(function () {

                Route::put('/', UpdateProjectController::class)
                    ->name('projects.update');

                Route::prefix('tasks')
                    ->group(function () {

                        Route::get('/', IndexTaskController::class)->name('projects.tasks.index');
                        Route::post('/', StoreTaskController::class)->name('tasks.store');

                    });

            });

    });
