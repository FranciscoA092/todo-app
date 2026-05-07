<?php

use App\Domains\Project\Controllers\StoreProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('projects')
    ->group(function () {

        Route::post('/', StoreProjectController::class)
            ->name('projects.store');

    });
