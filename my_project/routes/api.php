<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackpackController;
use App\Http\Controllers\ItemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/backpack/{id}', [BackpackController::class, 'show']);
Route::post('/backpack/add', [BackpackController::class, 'add']);
Route::delete('/backpack/{id}', [BackpackController::class, 'delete']);

Route::get('/item/{id}', [ItemController::class, 'index']);
Route::patch('/item/use/{id}', [ItemController::class, 'useItem']);