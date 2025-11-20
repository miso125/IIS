<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WineyardRowController;
use Illuminate\Support\Facades\Route;

// Len admins
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

// Len vinári
Route::middleware(['auth', 'role:winemaker'])->group(function () {
    Route::resource('winerows', WineyardRowController::class);
});

// Ľubovolná rola, ale len s permission
Route::middleware(['auth', 'permission:create winerow'])->group(function () {
    Route::post('/winerows', [WineyardRowController::class, 'store']);
});
