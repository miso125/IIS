<?php

use App\Http\Controllers\AuthController;
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
    return view('welcome');
})->name('home');


/* 
Route::middleware('auth')->group(function () {

    // Treatments: vinar can view index/show, worker can do all
    Route::get('/treatments', [TreatmentController::class, 'index'])->middleware('role:winemaker|worker')->name('treatments.index');
    Route::get('/treatments/{treatment}', [TreatmentController::class, 'show'])->middleware('role:winemaker|worker')->name('treatments.show');

    // Worker-only routes
    Route::middleware('role:worker')->group(function () {
        Route::get('/treatments/create', [TreatmentController::class, 'create'])->name('treatments.create');
        Route::post('/treatments', [TreatmentController::class, 'store'])->name('treatments.store');
        Route::get('/treatments/{treatment}/edit', [TreatmentController::class, 'edit'])->name('treatments.edit');
        Route::put('/treatments/{treatment}', [TreatmentController::class, 'update'])->name('treatments.update');
        Route::delete('/treatments/{treatment}', [TreatmentController::class, 'destroy'])->name('treatments.destroy');
    });

});

 */


// ============================================
// Autentifikácia (Login, Logout, Register)
// ============================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ============================================
// Autorizované routes – Len pre prihlásených
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
    // Vinar Routes
    // ============================================
    Route::middleware('role:winemaker')->group(function () {
        Route::resource('vineyards', WineyardRowController::class);
        Route::resource('harvests', HarvestController::class);
        Route::resource('treatments', TreatmentController::class);
        Route::resource('wine_batches', WineBatchController::class);
        Route::post('/harvests/{harvest}/bottle', [WineBatchController::class, 'createFromHarvest'])
             ->name('harvests.bottle');
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
