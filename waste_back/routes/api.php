<?php

use App\Http\Controllers\API\CommonController;
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
    return $request->user()->load('aimag_city:id,name')->load('bag_horoo:id,name')->load('soum_district:id,name');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('attached_files', App\Http\Controllers\API\AttachedFileAPIController::class);
    Route::resource('bag_horoos', App\Http\Controllers\API\BagHorooAPIController::class);
    Route::resource('places', App\Http\Controllers\API\PlaceAPIController::class);
    Route::resource('reasons', App\Http\Controllers\API\ReasonAPIController::class);
    Route::resource('statuses', App\Http\Controllers\API\StatusAPIController::class);
    Route::resource('entities', App\Http\Controllers\API\LegalEntityAPIController::class);
    Route::resource('registers', App\Http\Controllers\API\RegisterAPIController::class);
    Route::resource('register_histories', App\Http\Controllers\API\RegisterHistoryAPIController::class);
    Route::resource('aimag_cities', App\Http\Controllers\API\AimagCityAPIController::class);
    Route::resource('soum_districts', App\Http\Controllers\API\SoumDistrictAPIController::class);
    Route::resource('users', App\Http\Controllers\API\UserAPIController::class);
    Route::put('save_token', [UserAPIController::class, 'save_token'])->name('api.save_token');
    Route::resource('industries', App\Http\Controllers\API\IndustryAPIController::class);

    Route::post('/registers/{register}/resolve', [App\Http\Controllers\API\RegisterAPIController::class, 'resolve'])->name('resolve.index');
    Route::put('/registers/{register}/allocation', [App\Http\Controllers\API\RegisterAPIController::class, 'allocation_store'])->name('register.allocation_store');
    Route::resource('notifications', App\Http\Controllers\API\NotificationAPIController::class);
});
Route::get('/commons', [CommonController::class, 'index'])->name('commons.index');



Route::post('/login', [UserAPIController::class, 'login'])->name('api.login');
Route::post('/signup', [UserAPIController::class, 'store'])->name('api.signup');

// Route::group(['prefix' => 'admin'], function () {
//     Route::resource('registers', App\Http\Controllers\API\RegisterAPIController::class);
// });


// Route::group(['prefix' => 'admin'], function () {
//     Route::resource('attached_files', App\Http\Controllers\API\AttachedFileAPIController::class);
// });

// Route::group(['prefix' => 'admin'], function () {
//     Route::resource('resolves', App\Http\Controllers\API\ResolveAPIController::class);
// });


// Route::group(['prefix' => 'admin'], function () {
//     Route::resource('legal_entities', App\Http\Controllers\API\LegalEntityAPIController::class);
// });
