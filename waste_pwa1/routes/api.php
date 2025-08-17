<?php

use App\Http\Controllers\API\CommonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('common', [CommonController::class, 'index'])
    ->name('common');
