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

// LegalEntity
Route::resource('entities', App\Http\Controllers\Admin\LegalEntityController::class);


// Registers
Route::resource('registers', App\Http\Controllers\Admin\RegisterController::class);

// RegisterHistories
Route::resource('register_histories', App\Http\Controllers\Admin\RegisterHistoryController::class);

// AimagCities
Route::resource('aimag_cities', App\Http\Controllers\Admin\AimagCityController::class);

// SoumDistricts
Route::resource('soum_districts', App\Http\Controllers\Admin\SoumDistrictController::class);

// UsersModels
Route::resource('users', App\Http\Controllers\Admin\UsersController::class);