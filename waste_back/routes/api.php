<?php

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


Route::group(['prefix' => 'admin'], function () {
    Route::resource('attached_files', App\Http\Controllers\API\AttachedFileAPIController::class);
});


Route::group(['prefix' => 'admin'], function () {
    Route::resource('bag_horoos', App\Http\Controllers\API\BagHorooAPIController::class);
});


Route::group(['prefix' => 'admin'], function () {
    Route::resource('places', App\Http\Controllers\API\PlaceAPIController::class);
});


Route::group(['prefix' => 'admin'], function () {
    Route::resource('reasons', App\Http\Controllers\API\ReasonAPIController::class);
});


Route::group(['prefix' => 'admin'], function () {
    Route::resource('statuses', App\Http\Controllers\API\StatusAPIController::class);
});


Route::group(['prefix' => 'admin'], function () {
    Route::resource('registers', App\Http\Controllers\API\RegisterAPIController::class);
});


Route::group(['prefix' => 'admin'], function () {
    Route::resource('register_histories', App\Http\Controllers\API\RegisterHistoryAPIController::class);
});
