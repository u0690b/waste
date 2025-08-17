<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('/', [IndexController::class, 'index'])
        ->name('dashboard');
    Route::get('/create', [IndexController::class, 'create'])
        ->name('create');
    Route::get('/draft', [IndexController::class, 'draft'])
        ->name('draft');
    Route::get('/send', [IndexController::class, 'send'])
        ->name('send');
    Route::get('/solved', [IndexController::class, 'solved'])
        ->name('solved');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
