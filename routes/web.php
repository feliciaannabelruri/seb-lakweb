<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ToppingController;
use Illuminate\Support\Facades\Auth;

// Admin routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        // Orders - Urutan route penting
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}/view', [AdminController::class, 'viewOrder'])->name('orders.view');
        Route::get('/orders/filter/{status}', [AdminController::class, 'orders'])->name('orders.filter');
        Route::get('/orders/{order}/details', [AdminController::class, 'orderDetails'])->name('orders.details');
        Route::post('/orders/{order}/status', [AdminController::class, 'updateStatus'])->name('orders.status');
        Route::post('/orders/{order}/reject', [AdminController::class, 'rejectOrder'])->name('orders.reject');
        Route::post('/orders/delete-multiple', [AdminController::class, 'deleteMultiple'])->name('orders.delete-multiple');

        // Toppings Management
        Route::get('/toppings', [ToppingController::class, 'index'])->name('toppings.index');
        Route::post('/toppings', [ToppingController::class, 'store'])->name('toppings.store');
        Route::post('/toppings/{topping}/stock', [ToppingController::class, 'updateStock'])->name('toppings.stock');
        Route::post('/toppings/{topping}/toggle-availability', [ToppingController::class, 'toggleAvailability'])->name('toppings.toggle-availability');
        Route::get('/toppings/{topping}/edit', [ToppingController::class, 'edit'])->name('toppings.edit');
        Route::put('/toppings/{topping}', [ToppingController::class, 'update'])->name('toppings.update');
        Route::delete('/toppings/{topping}', [ToppingController::class, 'destroy'])->name('toppings.destroy');
    });
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1'); // 5 percobaan per 1 menit    
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Forgot password routes
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

// Auth routes
Route::middleware('auth')->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::delete('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Payment
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/proof', [PaymentController::class, 'uploadProof'])->name('payment.proof');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Root route
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->is_admin ? 
            redirect()->route('admin.orders') : 
            redirect()->route('menu');
    }
    return redirect()->route('login');
});

// Animation session route
Route::get('/set-animation-shown', function() {
    session(['animation_shown' => true]);
    return response()->json(['success' => true]);
})->name('set.animation.shown');