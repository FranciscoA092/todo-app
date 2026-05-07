<?php

use App\Domains\Project\Controllers\StoreProjectController;
use App\Domains\Project\Controllers\UpdateProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('projects')
    ->group(function () {

        Route::post('/', StoreProjectController::class)
            ->name('projects.store');

        Route::put('/{id}', UpdateProjectController::class)
            ->name('projects.update');

    });
