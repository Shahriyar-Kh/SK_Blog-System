<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// -----------------------------
// Public Route
// -----------------------------
Route::get('/', function () {
    return view('welcome');
});

// -----------------------------
// Admin Route Group
// -----------------------------
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        // -----------------------------------------
        // Guest Admin Routes (login, forgot, etc.)
        // -----------------------------------------
        Route::middleware([])
            ->group(function () {

                Route::controller(AuthController::class)->group(function () {

                    // Admin Login Page
                    Route::get('/login', 'LoginForm')
                        ->name('login');
                        // Route for POST login can be added here
                        Route::post('/login', 'loginHandler')->name('login_submit');

                    // Forgot Password Page
                    Route::get('/forgot-password', 'forgotForm')
                        ->name('forgot-password');
                });
            });

        // -----------------------------------------
        // Authenticated Admin Routes (dashboard)
        // -----------------------------------------
        Route::middleware([])
            ->group(function () {

                Route::controller(AdminController::class)->group(function () {

                    // Dashboard Page
                    Route::get('/dashboard', 'adminDashboard')
                        ->name('dashboard');
                });
            });
    });


    // ----------------------------- Testing Routes -----------------
    Route::view('/example-page','example-page');
    Route::view('/example-auth','example-auth');