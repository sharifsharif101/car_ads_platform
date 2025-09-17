@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-primary">لوحة التحكم</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <!-- بطاقة الإعلانات -->
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
        <h2 class="text-xl font-semibold mb-2">إجمالي الإعلانات</h2>
        <p class="text-3xl font-bold text-accent">120</p>
        <p class="text-sm text-gray-500 mt-1">عدد جميع الإعلانات المضافة</p>
    </div>

    <!-- بطاقة المستخدمين -->
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
        <h2 class="text-xl font-semibold mb-2">إجمالي المستخدمين</h2>
        <p class="text-3xl font-bold text-accent">45</p>
        <p class="text-sm text-gray-500 mt-1">عدد المستخدمين المسجلين</p>
    </div>

    <!-- بطاقة التصنيفات -->
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
        <h2 class="text-xl font-semibold mb-2">عدد التصنيفات</h2>
        <p class="text-3xl font-bold text-accent">12</p>
        <p class="text-sm text-gray-500 mt-1">عدد التصنيفات المتاحة</p>
    </div>

    <!-- بطاقة الوسوم -->
    <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
        <h2 class="text-xl font-semibold mb-2">عدد الوسوم</h2>
        <p class="text-3xl font-bold text-accent">30</p>
        <p class="text-sm text-gray-500 mt-1">الوسوم المضافة</p>
    </div>
</div>
@endsection
