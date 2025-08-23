<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackpackController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/backpack/{id}', [BackpackController::class, 'show']);
Route::post('/backpack/add', [BackpackController::class, 'add']);
Route::delete('/backpack/{id}', [BackpackController::class, 'delete']);