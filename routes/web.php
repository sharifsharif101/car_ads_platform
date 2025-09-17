<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CategoryController;
 
Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // إدارة الإعلانات
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
      Route::resource('cars', CarController::class);
    // مسار مخصص لحذف صورة إضافية
    Route::delete('/cars/images/{image}', [CarController::class, 'destroyImage'])->name('cars.images.destroy');



    // إدارة التصنيفات
    Route::resource('categories', CategoryController::class); // قم بتفعيل وتعديل هذا السطر
    Route::resource('tags', App\Http\Controllers\Admin\TagController::class);


    // // إدارة الوسوم
    // Route::get('/tags', [TagController::class, 'index'])->name('tags.index');

    // // إدارة المستخدمين
    // Route::get('/users', [UserController::class, 'index'])->name('users.index');

});