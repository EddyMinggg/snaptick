<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ===== 商戶後台（需登入 + 已驗證 + 已設定商戶）=====
Route::middleware(['auth', 'verified', 'check.merchant'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/records/{id}/approve', [DashboardController::class, 'approve'])->name('dashboard.approve');
    Route::post('/dashboard/records/{id}/reject', [DashboardController::class, 'reject'])->name('dashboard.reject');
});

// 商戶 Onboarding（不加 check.merchant，避免無窮迴圈）
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/setup', [MerchantController::class, 'create'])->name('merchant.setup');
    Route::post('/setup', [MerchantController::class, 'store'])->name('merchant.setup.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== 顧客公開入數頁面（不需登入）=====
Route::get('/pay/{slug}', [\App\Http\Controllers\PaymentController::class, 'showForm'])->name('payment.form');
Route::post('/pay/{slug}/submit', [\App\Http\Controllers\PaymentController::class, 'submitForm'])->name('payment.submit');
Route::get('/pay/{slug}/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');

require __DIR__.'/auth.php';
