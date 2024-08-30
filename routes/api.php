<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventUserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [UserController::class, 'store']);


Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{user}', [UserController::class, 'show']);
Route::put('/user/{user}', [UserController::class, 'update']);
Route::delete('/user/{user}', [UserController::class, 'destroy'])->withTrashed();


Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);
Route::post('/events', [EventController::class, 'store']);
Route::put('/events/{event}', [EventController::class, 'update']);
Route::delete('/events/{event}', [EventController::class, 'destroy'])->withTrashed();

Route::get('/eventuser', [EventUserController::class, 'index']);
Route::get('/MyEvent', [EventUserController::class, 'show']);
