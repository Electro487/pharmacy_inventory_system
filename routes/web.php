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
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\MedicineController as CustomerMedicineController;

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
Route::middleware(['auth'])->group(function () {
    // Dashboard Page for all staff users (Admin, Pharmacist, Cashier)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Only
    Route::middleware('role:Admin')->group(function () {
        Route::resource('users', UserController::class);
    });

// Admin + Pharmacist
Route::middleware('role:Admin,Pharmacist')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('units', UnitController::class);
    Route::resource('medicines', MedicineController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('orders', OrderController::class)->only(['index', 'show']);
    Route::patch('orders/{order}/approve', [OrderController::class, 'approve'])->name('orders.approve');
    Route::patch('orders/{order}/reject', [OrderController::class, 'reject'])->name('orders.reject');
});

    // Everyone (Admin, Pharmacist, Cashier)
    Route::middleware('role:Admin,Pharmacist,Cashier')->group(function () {
        Route::resource('customers', CustomerController::class)->except(['create', 'store']);
        Route::resource('sales', SaleController::class)->only(['index', 'show']);
    });
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
            Route::get('/dashboard', [CustomerDashboardController::class, 'dashboard'])->name('dashboard');
            Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');

            Route::get('/medicines', [CustomerMedicineController::class, 'index'])->name('medicines');
            Route::get('/medicines/{medicine}', [CustomerMedicineController::class, 'show'])->name('medicines.show');

            Route::get('/cart', [CartController::class, 'index'])->name('cart');
            Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
            Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
            Route::patch('/cart/{cartItemId}', [CartController::class, 'update'])->name('cart.update');
            Route::delete('/cart/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
            Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        });
    });

Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
