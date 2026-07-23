<?php

use Illuminate\Support\Facades\Route;

// Import API Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\Admin\MuseumItemController as AdminMuseumItemController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\Admin\LoanRequestMonitorController as AdminLoanRequestMonitorController;

use App\Http\Controllers\Api\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Api\Staff\LoanRequestVerificationController as StaffVerificationController;

use App\Http\Controllers\Api\Panitia\DashboardController as PanitiaDashboardController;
use App\Http\Controllers\Api\Panitia\LoanRequestController as PanitiaLoanRequestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth Routes (Public)
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Sesi Login Terverifikasi via Token Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Info Akun & Logout
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // ==========================================
    // 1. ENDPOINT ADMIN (Role: admin)
    // ==========================================
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', AdminDashboardController::class);
        Route::apiResource('/museum-items', AdminMuseumItemController::class);
        Route::apiResource('/users', AdminUserController::class);
        Route::patch('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword']);
        Route::get('/loan-requests', [AdminLoanRequestMonitorController::class, 'index']);
    });

    // ==========================================
    // 2. ENDPOINT STAF (Role: staff)
    // ==========================================
    Route::middleware('role:staff')->prefix('staff')->group(function () {
        Route::get('/dashboard', StaffDashboardController::class);
        Route::get('/verifications', [StaffVerificationController::class, 'index']);
        Route::patch('/verifications/{loan_request}/verify', [StaffVerificationController::class, 'verify']);
    });

    // ==========================================
    // 3. ENDPOINT PANITIA (Role: panitia)
    // ==========================================
    Route::middleware('role:panitia')->prefix('panitia')->group(function () {
        Route::get('/dashboard', PanitiaDashboardController::class);
        Route::get('/catalog', [PanitiaLoanRequestController::class, 'catalog']);
        Route::get('/loan-requests', [PanitiaLoanRequestController::class, 'index']);
        Route::post('/loan-requests', [PanitiaLoanRequestController::class, 'store']);
    });
});
