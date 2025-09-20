@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-semibold text-primary tracking-tight">لوحة التحكم</h1>
        <p class="mt-2 text-gray-600 max-w-2xl mx-auto">نظرة عامة على الإحصائيات الرئيسية في النظام</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <!-- بطاقة الإعلانات -->
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">إجمالي الإعلانات</h2>
            <p class="text-3xl font-bold text-accent">{{ $carsCount }}</p>
            <p class="text-sm text-gray-500 mt-1">عدد جميع الإعلانات المضافة</p>
        </div>

        <!-- بطاقة المستخدمين -->
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">إجمالي المستخدمين</h2>
            <p class="text-3xl font-bold text-accent">{{ $usersCount }}</p>
            <p class="text-sm text-gray-500 mt-1">عدد المستخدمين المسجلين</p>
        </div>

        <!-- بطاقة التصنيفات -->
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">عدد التصنيفات</h2>
            <p class="text-3xl font-bold text-accent">{{ $categoriesCount }}</p>
            <p class="text-sm text-gray-500 mt-1">عدد التصنيفات المتاحة</p>
        </div>

        <!-- يمكنك إضافة المزيد من البطاقات هنا بنفس الشكل -->
    </div>
</div>
@endsection