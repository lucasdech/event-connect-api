<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventUserController;
use App\Http\Controllers\MessageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [UserController::class, 'store']);


Route::get('/users', [UserController::class, 'index']);
Route::get('/user/{user}', [UserController::class, 'show']);
Route::put('/user/{user}', [UserController::class, 'update']);
Route::delete('/user/{user}', [UserController::class, 'destroy']);


Route::get('/events', [EventController::class, 'index']);
Route::get('/event/{event}', [EventController::class, 'show']);
Route::post('/event', [EventController::class, 'store']);
Route::put('/event/{event}', [EventController::class, 'update']);
Route::delete('/event/{event}', [EventController::class, 'destroy']);

Route::get('/messages', [MessageController::class, 'index'])->withTrashed();
Route::get('/message/{message}', [MessageController::class, 'show']);
Route::post('/message', [MessageController::class, 'store']);
Route::put('/message/{message}', [MessageController::class, 'update']);
Route::delete('/message/{message}', [MessageController::class, 'destroy']);

Route::get('/eventuser', [EventUserController::class, 'index']);
Route::get('/MyEvents/{id}', [EventUserController::class, 'show']);
Route::delete('/MyEvents/{id}', [EventUserController::class, 'destroy']);

