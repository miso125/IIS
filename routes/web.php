<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WineyardRowController;
use App\Http\Controllers\HarvestController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\WineBatchController;
use App\Models\WineBatch;
use Illuminate\Support\Facades\Route;
use App\Models\User;


Route::get('/', function () {
    $users = User::take(5)->get();
    return view('home', compact('users'));
});

Route::get('/guest', function () {
    $wine = WineBatch::take(5)->get();
    return view('layouts/guest', compact('wine'));
});
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


Route::get('/user', function () {
    return view('uzivatele');
});

// ============================================
// Autentifikácia (Login, Logout, Register)
// ============================================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // Implementuj vlastnú logiku alebo použi Laravel Breeze/Jetstream
})->name('login.post');

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// ============================================
// Autorizované routes – Len pre prihlásených
// ============================================
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Resource routes s middleware na úrovni grupy
    Route::resources([
        'users' => UserController::class,
        'winerows' => WineyardRowController::class,
        'harvests' => HarvestController::class,
        'treatments' => TreatmentController::class,
        'purchases' => PurchaseController::class,
        'batches' => WineBatchController::class,
    ]);

    // Vnorené resources – Sklizne konkrétneho vinoradka
    Route::get('/winerows/{wineyardrow}/harvests', [HarvestController::class, 'indexByWineyardRow'])
        ->name('winerows.harvests');

    // Nákupy konkrétneho užívateľa
    Route::get('/my-purchases', [PurchaseController::class, 'myPurchases'])
        ->name('my-purchases');
});

// ============================================
// Admin routes – Len pre admins
// ============================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/admin/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');
});