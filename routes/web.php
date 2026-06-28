<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import Controllers
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MuseumItemController as AdminMuseumItemController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\LoanRequestMonitorController as AdminLoanRequestMonitorController;

use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\LoanRequestVerificationController as StaffVerificationController;

use App\Http\Controllers\Panitia\DashboardController as PanitiaDashboardController;
use App\Http\Controllers\Panitia\LoanRequestController as PanitiaLoanRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama otomatis diarahkan sesuai status login & role
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();
    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'staff' => redirect()->route('staff.dashboard'),
        'panitia' => redirect()->route('panitia.dashboard'),
        default => redirect()->route('login'),
    };
});

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth'])->name('dashboard');

// ==========================================
// 1. FITUR ADMIN (Role: admin)
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

    // CRUD Barang Museum
    Route::resource('/museum-items', AdminMuseumItemController::class);

    // CRUD User
    Route::resource('/users', AdminUserController::class);
    Route::patch('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');

    // Monitoring Pengajuan (Read-Only)
    Route::get('/loan-requests', [AdminLoanRequestMonitorController::class, 'index'])->name('loan-requests.index');
});

// ==========================================
// 2. FITUR STAF (Role: staff)
// ==========================================
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    // Dashboard
    Route::get('/dashboard', StaffDashboardController::class)->name('dashboard');

    // Verifikasi Peminjaman
    Route::get('/verifications', [StaffVerificationController::class, 'index'])->name('verifications.index');
    Route::patch('/verifications/{loan_request}/verify', [StaffVerificationController::class, 'verify'])->name('verifications.verify');
});

// ==========================================
// 3. FITUR PANITIA (Role: panitia)
// ==========================================
Route::middleware(['auth', 'role:panitia'])->prefix('panitia')->name('panitia.')->group(function () {
    // Dashboard
    Route::get('/dashboard', PanitiaDashboardController::class)->name('dashboard');

    // Katalog Barang (Grid Card)
    Route::get('/catalog', [PanitiaLoanRequestController::class, 'catalog'])->name('catalog');

    // Pengajuan Peminjaman
    Route::get('/loan-requests', [PanitiaLoanRequestController::class, 'index'])->name('loan-requests.index');
    Route::get('/loan-requests/create/{museum_item}', [PanitiaLoanRequestController::class, 'create'])->name('loan-requests.create');
    Route::post('/loan-requests', [PanitiaLoanRequestController::class, 'store'])->name('loan-requests.store');
});

// Route bawaan otomatis dari Laravel Breeze (Jangan dihapus)
require __DIR__.'/auth.php';