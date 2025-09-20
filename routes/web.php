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
Route::get('/', [FrontCarController::class, 'index'])->name('cars.front.index');


// عرض السيارات أمام المستخدمين
 
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



// كود اختبار الايميل
// Route::get('/send-test-email', function () {
//     try {
//         Mail::raw('This is a test email from Laravel with Gmail SMTP.', function ($message) {
//             $message->to('abd.sha.dev.1991@gmail.com') // أرسل لنفسك للتجربة
//                     ->subject('Laravel Gmail Test');
//         });

//         return '✅ Email sent successfully!';
//     } catch (\Exception $e) {
//         return '❌ Error: ' . $e->getMessage();
//     }
// });
// http://localhost:8000/send-test-email