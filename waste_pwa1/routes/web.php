<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('/', [IndexController::class, 'index'])
        ->name('dashboard');
    Route::get('/create', [IndexController::class, 'create'])
        ->name('create');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
