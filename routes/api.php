<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventUserController;
use App\Http\Controllers\MessageController;


Route::post('/register', [UserController::class, 'store']); //
Route::post('/login', [UserController::class, 'login']); //
Route::get('/users', [UserController::class, 'index']); //


Route::get('/events', [EventController::class, 'index']); //
Route::get('/event/{event}', [EventController::class, 'show']); //

Route::group([

    'middleware' => 'auth:api',

], function ($router) {

    Route::get('/user/{user}', [UserController::class, 'show']); //
    Route::put('/user/{user}', [UserController::class, 'update']); //
    Route::delete('/user/{user}', [UserController::class, 'destroy']); //


    Route::post('/event', [EventController::class, 'store']);//
    Route::put('/event/{event}', [EventController::class, 'update']); //
    Route::delete('/event/{event}', [EventController::class, 'destroy']); //

    Route::get('/messages', [MessageController::class, 'index']); //
    Route::get('/message/{message}', [MessageController::class, 'show']); //
    Route::post('/message', [MessageController::class, 'store']); //
    Route::put('/message/{message}', [MessageController::class, 'update']);
    Route::delete('/message/{message}', [MessageController::class, 'destroy']);


    Route::get('/eventuser', [EventUserController::class, 'index']); //
    Route::get('/MyEvents', [EventUserController::class, 'show']); //
    Route::post('/MyEvent/participate', [EventUserController::class, 'store']); //
    Route::delete('/MyEvent/{EventUser}', [EventUserController::class, 'destroy']); //

});


