<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('home');
Route::get('/test', [IndexController::class, 'sendNotificationrToUser'])->name('reg.sendNotificationrToUser');

// Registers
Route::get('/reg', [IndexController::class, 'register'])->name('reg.index');
Route::get('/reg/{register}', [IndexController::class, 'show'])->name('reg.show');
Route::get('/', [IndexController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [IndexController::class, 'index'])->name('dashboard');

// Route::get('/dashboard', [IndexController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/map', [IndexController::class, 'map'])->name('register.map');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';


Route::middleware('auth')->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/report', [App\Http\Controllers\ReportController::class, 'index'])->name('tailan');
    require __DIR__ . '/admin.php';

    // Route::delete('/logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('logout');
});
