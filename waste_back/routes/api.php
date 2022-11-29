<?php

use App\Http\Controllers\API\UserAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('attached_files', App\Http\Controllers\API\AttachedFileAPIController::class);
    Route::resource('bag_horoos', App\Http\Controllers\API\BagHorooAPIController::class);
    Route::resource('places', App\Http\Controllers\API\PlaceAPIController::class);
    Route::resource('reasons', App\Http\Controllers\API\ReasonAPIController::class);
    Route::resource('statuses', App\Http\Controllers\API\StatusAPIController::class);
    Route::resource('registers', App\Http\Controllers\API\RegisterAPIController::class);
    Route::resource('register_histories', App\Http\Controllers\API\RegisterHistoryAPIController::class);
    Route::resource('aimag_cities', App\Http\Controllers\API\AimagCityAPIController::class);
    Route::resource('soum_districts', App\Http\Controllers\API\SoumDistrictAPIController::class);
    Route::resource('users', App\Http\Controllers\API\UserAPIController::class);
});



Route::post('/login', [UserAPIController::class, 'login'])->name('api.login');
