<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\FrontCarController;

// =======================================
// الروتات العامة (Public Routes)
// =======================================

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// عرض السيارات أمام المستخدمين
Route::get('/cars', [FrontCarController::class, 'index'])->name('cars.front.index');
Route::get('/cars/{car}', [FrontCarController::class, 'show'])->name('cars.front.show');

// =======================================
// الروتات الخاصة بالمستخدمين المسجلين
// =======================================

Route::middleware(['auth', 'verified'])->group(function () {
    // لوحة التحكم
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // إدارة الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ربط روتات المصادقة الخاصة بـ Breeze
require __DIR__.'/auth.php';

// =======================================
// الروتات الخاصة بالمسؤول (Admin Routes)
// =======================================

Route::prefix('admin')->name('admin.')->group(function () {
    // لوحة تحكم المسؤول
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // إدارة الإعلانات (Cars)
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
    Route::resource('cars', CarController::class);

    // مسار لحذف صورة إضافية
    Route::delete('/cars/images/{image}', [CarController::class, 'destroyImage'])->name('cars.images.destroy');

    // إدارة التصنيفات
    Route::resource('categories', CategoryController::class);

 
});
