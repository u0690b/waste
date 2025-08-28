<?php

use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::prefix("/mobile")->group(function () {
Route::middleware('auth')->group(function () {
    Route::post('/save_token', [OAuthController::class, 'save_token'])->name('save_token');
    Route::get('/', [IndexController::class, 'index'])->name('home');
    Route::get('/home', [IndexController::class, 'index'])->name('dashboard');
    Route::get('/create', [IndexController::class, 'create'])->name('create');
    Route::get('/draft', [IndexController::class, 'draft'])->name('draft');
    Route::get('/send', [IndexController::class, 'send'])->name('send');
    Route::get('/solved', [IndexController::class, 'solved'])->name('solved');
    Route::put('/store', [IndexController::class, 'store'])->name('store');
    Route::get('/show/{register}', [IndexController::class, 'show'])->name('show');
    Route::get('/offline', [IndexController::class, 'offline'])->name('offline');
    Route::get('/notifications', [IndexController::class, 'notifications'])->name('notifications');
    Route::get('/storage/{filename}', [IndexController::class, 'storage'])->where('filename', '.*')->name('storage');

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
// });
