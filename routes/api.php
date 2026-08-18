<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MedicineController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerAuthController;
use App\Http\Controllers\Api\OrderController;

use App\Http\Controllers\Api\Customer\MedicineController as CustomerMedicineController;
use App\Http\Controllers\Api\Customer\CartController;
use App\Http\Controllers\Api\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\UserController;

Route::prefix('v1')->group(function () {

    // Authentication
    Route::post('/login', [AuthController::class, 'login']);

    // Customer Authentication
    Route::post('/customer/register', [CustomerAuthController::class, 'register']);
    Route::post('/customer/login', [CustomerAuthController::class, 'login']);


    // Authenticated APIs
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        // Admin Only
        Route::middleware('role:Admin')->group(function () {

            // Users
            Route::get('/users', [UserController::class, 'index']);
            Route::get('/users/{user}', [UserController::class, 'show']);
            Route::post('/users', [UserController::class, 'store']);
            Route::put('/users/{user}', [UserController::class, 'update']);
            Route::delete('/users/{user}', [UserController::class, 'destroy']);
        });

        // Admin + Pharmacist
        Route::middleware('role:Admin,Pharmacist')->group(function () {

            // Medicines
            Route::get('/medicines', [MedicineController::class, 'index']);
            Route::get('/medicines/{medicine}', [MedicineController::class, 'show']);
            Route::post('/medicines', [MedicineController::class, 'store']);
            Route::put('/medicines/{medicine}', [MedicineController::class, 'update']);
            Route::delete('/medicines/{medicine}', [MedicineController::class, 'destroy']);

            // Categories
            Route::get('/categories', [CategoryController::class, 'index']);
            Route::get('/categories/{category}', [CategoryController::class, 'show']);
            Route::post('/categories', [CategoryController::class, 'store']);
            Route::put('/categories/{category}', [CategoryController::class, 'update']);
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

            // Units
            Route::get('/units', [UnitController::class, 'index']);
            Route::get('/units/{unit}', [UnitController::class, 'show']);
            Route::post('/units', [UnitController::class, 'store']);
            Route::put('/units/{unit}', [UnitController::class, 'update']);
            Route::delete('/units/{unit}', [UnitController::class, 'destroy']);

            // Suppliers
            Route::get('/suppliers', [SupplierController::class, 'index']);
            Route::get('/suppliers/{supplier}', [SupplierController::class, 'show']);
            Route::post('/suppliers', [SupplierController::class, 'store']);
            Route::put('/suppliers/{supplier}', [SupplierController::class, 'update']);
            Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy']);

            // Purchases
            Route::get('/purchases', [PurchaseController::class, 'index']);
            Route::get('/purchases/{purchase}', [PurchaseController::class, 'show']);
            Route::post('/purchases', [PurchaseController::class, 'store']);
        });


        // Admin + Pharmacist + Cashier
        Route::middleware('role:Admin,Pharmacist,Cashier')->group(function () {

            // Orders
            Route::get('/orders', [OrderController::class, 'index']);
            Route::get('/orders/{order}', [OrderController::class, 'show']);
            Route::patch('/orders/{order}/approve', [OrderController::class, 'approve']);
            Route::patch('/orders/{order}/reject', [OrderController::class, 'reject']);
            Route::patch('/orders/{order}/complete', [OrderController::class, 'complete']);

            // Sales
            Route::get('/sales', [SaleController::class, 'index']);
            Route::get('/sales/{sale}', [SaleController::class, 'show']);

            // Customers
            Route::get('/customers', [CustomerController::class, 'index']);
            Route::get('/customers/{customer}', [CustomerController::class, 'show']);
            Route::put('/customers/{customer}', [CustomerController::class, 'update']);
            Route::delete('/customers/{customer}', [CustomerController::class, 'destroy']);
        });


        // Customer APIs
        Route::prefix('customer')->group(function () {

            Route::post('/logout', [CustomerAuthController::class, 'logout']);

            // Medicines
            Route::get('/medicines', [CustomerMedicineController::class, 'index']);
            Route::get('/medicines/{medicine}', [CustomerMedicineController::class, 'show']);

            // Cart
            Route::get('/cart', [CartController::class, 'index']);
            Route::post('/cart/items', [CartController::class, 'add']);
            Route::patch('/cart/items/{cartItemId}', [CartController::class, 'update']);
            Route::delete('/cart/items/{cartItemId}', [CartController::class, 'remove']);
            Route::delete('/cart', [CartController::class, 'clear']);

            // Orders
            Route::get('/orders', [CustomerOrderController::class, 'index']);
            Route::get('/orders/{order}', [CustomerOrderController::class, 'show']);

            // Checkout
            Route::post('/checkout', [CustomerOrderController::class, 'checkout']);
        });
    });
});