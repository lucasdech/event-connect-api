<?php

use Illuminate\Support\Facades\Route;
use Filament\Facades\Filament;

Route::get('/', function () {
    return view('LandingApi');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Ajoutez ces lignes pour Filament
Route::domain(config('filament.domain'))
    ->middleware(config('filament.middleware.base'))
    ->prefix(config('filament.path'))
    ->group(function () {
        Filament::registerRenderHook(
            'styles.after',
            fn (): string => '<link rel="stylesheet" href="' . asset('css/custom.css') . '">'
        );
    });
