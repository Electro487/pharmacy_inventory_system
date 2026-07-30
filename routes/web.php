<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerAuthController;    
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware('auth')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);
    Route::resource('units', UnitController::class);
    Route::resource('medicines', MedicineController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('customers', CustomerController::class)->except(['create', 'store']);
    Route::resource('sales', SaleController::class);
});

Route::prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::middleware('guest:customer')->group(function () {
            Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('register');
            Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.store');
            Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('login');
            Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.store');
        });

        Route::middleware('auth:customer')->group(function () {
            Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
            Route::get('/dashboard', [CustomerAuthController::class, 'dashboard'])->name('dashboard');
        });
    });

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
