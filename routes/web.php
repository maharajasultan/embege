<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\BudgetController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\SalaryController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =====================
// Frontend Publik (tanpa autentikasi)
// =====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');

// =====================
// Backend Admin
// =====================

// Auth Routes (tidak perlu login)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Protected Admin Routes (butuh login + role admin)
Route::prefix('admin')->name('admin.')->middleware(['web', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Menu
    Route::resource('menus', MenuController::class);
    Route::resource('staffs', StaffController::class);
    Route::resource('schools', SchoolController::class);

    // Keuangan & SDM
    Route::resource('budgets', BudgetController::class)->except(['show']);
    
    Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::post('attendances', [AttendanceController::class, 'store'])->name('attendances.store');

    Route::get('salaries', [SalaryController::class, 'index'])->name('salaries.index');
    Route::post('salaries/generate', [SalaryController::class, 'generate'])->name('salaries.generate');
    Route::get('salaries/{salary}/edit', [SalaryController::class, 'edit'])->name('salaries.edit');
    Route::put('salaries/{salary}', [SalaryController::class, 'update'])->name('salaries.update');

    // Laporan
    Route::get('reports/menus', [ReportController::class, 'menus'])->name('reports.menus');
    Route::get('reports/budgets', [ReportController::class, 'budgets'])->name('reports.budgets');
    Route::get('reports/salaries', [ReportController::class, 'salaries'])->name('reports.salaries');


});
