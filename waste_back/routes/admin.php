<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// AttachedFiles
Route::resource('attached_files', App\Http\Controllers\Admin\AttachedFileController::class);

// BagHoroos
Route::resource('bag_horoos', App\Http\Controllers\Admin\BagHorooController::class);

// Places
Route::resource('places', App\Http\Controllers\Admin\PlaceController::class);

// Reasons
Route::resource('reasons', App\Http\Controllers\Admin\ReasonController::class);

// Statuses
Route::resource('statuses', App\Http\Controllers\Admin\StatusController::class);




// Registers
Route::resource('registers', App\Http\Controllers\Admin\RegisterController::class);
Route::get('/registers/{register}/resolve', [App\Http\Controllers\Admin\RegisterController::class, 'show_resolve'])->name('registers.show_resolve');
Route::put('/registers/{register}/resolve', [App\Http\Controllers\Admin\RegisterController::class, 'resolve'])->name('registers.resolve');
Route::get('/registers/{register}/allocation', [App\Http\Controllers\Admin\RegisterController::class, 'allocation'])->name('register.allocation');
Route::put('/registers/{register}/allocation', [App\Http\Controllers\Admin\RegisterController::class, 'allocation_store'])->name('register.allocation_store');

// RegisterHistories
Route::resource('register_histories', App\Http\Controllers\Admin\RegisterHistoryController::class);

// AimagCities
Route::resource('aimag_cities', App\Http\Controllers\Admin\AimagCityController::class);

// SoumDistricts
Route::resource('soum_districts', App\Http\Controllers\Admin\SoumDistrictController::class);

// UsersModels
Route::resource('users', App\Http\Controllers\Admin\UsersController::class);

// Resolves
Route::resource('resolves', App\Http\Controllers\Admin\ResolvesController::class);


// Notifications
Route::resource('notifications', App\Http\Controllers\Admin\NotificationController::class);

// Industries
Route::resource('industries', App\Http\Controllers\Admin\IndustryController::class);

// LegalEntities
Route::resource('entities', App\Http\Controllers\Admin\LegalEntityController::class);


// LegalEntities
Route::resource('legal_entities', App\Http\Controllers\Admin\LegalEntityController::class);