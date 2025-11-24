<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WineyardRowController;
use App\Http\Controllers\HarvestController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\WineBatchController;
use App\Models\WineyardRow;
use App\Models\WineBatch;
use Illuminate\Support\Facades\Route;
use App\Models\User;

// Welcome page
Route::get('/', function () {
    $wines = WineBatch::with('harvestDetail.wineyardrow')
                ->where('number_of_bottles', '>', 0)
                ->latest('date_time')
                ->get();

    // Calculate total vines for the "About Us" section
    $totalVines = WineyardRow::sum('number_of_vines');
    return view('welcome', compact('wines', 'totalVines'));
})->name('home');


// ============================================
// Autentificationa (Login, Logout, Register)
// ============================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ============================================
// Autorized roles
// ============================================
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:customer|winemaker|admin')->group(function () {
        Route::get('/wine_batches', [WineBatchController::class, 'index'])->name('wine_batches.index');
        Route::get('/wine_batches/{wine_batch}', [WineBatchController::class, 'show'])->name('wine_batches.show');
    });
    // ============================================
    // Admin Routes
    // ============================================
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // ============================================
    // Winemaker Routes
    // ============================================
    Route::middleware('role:winemaker')->group(function () {
        Route::resource('vineyards', WineyardRowController::class);
        Route::resource('harvests', HarvestController::class);
        Route::resource('treatments', TreatmentController::class);
        Route::resource('wine_batches', WineBatchController::class)->except(['index','show']);
        Route::get('/harvests/{harvest}/bottle', [WineBatchController::class, 'createFromHarvest'])
            ->name('harvests.bottle.create');
        Route::post('/harvests/{harvest}/bottle', [WineBatchController::class, 'storeFromHarvest'])
            ->name('harvests.bottle.store');
    });

    // ============================================
    // Worker Routes
    // ============================================
    Route::middleware('role:worker')->group(function () {
        Route::resource('harvests', HarvestController::class, ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
        Route::resource('treatments', TreatmentController::class, ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
    });

    // ============================================
    // Customer Routes
    // ============================================
    Route::middleware('role:customer')->group(function () {
        Route::resource('purchases', PurchaseController::class, ['only' => ['index', 'create', 'store']]);
        Route::get('/my-purchases', [PurchaseController::class, 'myPurchases'])->name('my-purchases');
    });
});

Route::middleware('auth')->group(function () {
    Route::middleware('role:winemaker|worker|admin')->group(function () {
        Route::resource('harvests', HarvestController::class);
    });

    Route::middleware('role:winemaker|worker|admin')->group(function () {
        Route::resource('treatments', TreatmentController::class);
    });
});

Route::get('/harvests/check-chemical/{wineRow}/{date}', [HarvestController::class, 'checkChemical'])
    ->name('harvests.checkChemical');

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

Route::post('/harvests/check-date', [HarvestController::class, 'checkDate']);
