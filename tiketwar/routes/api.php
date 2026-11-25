<?php

use App\Http\Controllers\Api\KonserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/konser', [KonserController::class, 'index'])
    ->name('api.konser.index');
Route::get('/konser/{konser}', [KonserController::class, 'show'])
    ->whereNumber('konser')->name('api.konser.show');