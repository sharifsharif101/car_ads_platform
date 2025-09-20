<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <style>
        /* استلهام ألوان التصميم */
        :root {
            --primary: #1e40af; /* أزرق داكن */
            --secondary: #dbeafe; /* أزرق فاتح */
            --accent: #fbbf24; /* ذهبي */
            --accent-dark: #f59e0b;
            --success: #10b981;
            --danger: #ef4444;
        }
        
        /* تحديث أنماط الجسم */
        body {
            background-color: #f3f4f6;
            font-family: 'Tajawal', sans-serif;
        }
        
        /* تحديث أنماط القائمة الجانبية */
        .bg-primary {
            background-color: var(--primary);
        }
        
        /* تحديث أنماط الروابط في القائمة */
        nav a {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }
        
        nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(-4px);
        }
        
        nav a.active {
            background-color: var(--accent);
            color: #000;
            font-weight: 600;
        }
        
        /* تحديث أنماط الهيدر */
        header {
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        /* تحديث أنماط المحتوى الرئيسي */
        main {
            background-color: #f9fafb;
        }
        
        /* تأثيرات حركية مستوحاة */
        .hover-scale {
            transition: transform 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.02);
        }
        
        /* تحديث أنماط الأزرار */
        .btn-primary {
            background-color: var(--accent);
            color: #000;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--accent-dark);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }
        
        /* تحديث أنماط الجداول */
        .table-container {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        
        table thead {
            background-color: var(--secondary);
            color: #1e293b;
        }
        
        table th {
            padding: 0.75rem 1rem;
            text-align: right;
            font-weight: 600;
        }
        
        table td {
            padding: 0.75rem 1rem;
            text-align: right;
        }
        
        table tbody tr {
            transition: background-color 0.2s ease;
        }
        
        table tbody tr:hover {
            background-color: #f3f4f6;
        }
        
        /* تحديث أنماط البطاقات */
        .card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
        }
        
        /* تحديث أنماط رسائل النجاح */
        .success-message {
            background-color: #f0fdf4;
            color: #166534;
            border-right: 4px solid var(--success);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* تحديث أنماط التباعد */
        .mb-6 { margin-bottom: 1.5rem; }
        .py-10 { padding-top: 2.5rem; padding-bottom: 2.5rem; }
        .text-primary { color: var(--primary); }
        
        /* تحديث أنماط العناوين */
        h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">

        <!-- Sidebar للـ Desktop (ثابت) -->
        <aside class="hidden md:flex w-64 flex-col bg-primary text-white shadow-lg">
            <div class="p-6 text-2xl font-bold border-b border-primary/80">
                <a href="{{ route('admin.dashboard') }}" class="hover-scale">لوحة التحكم</a>
            </div>
            
            <nav class="flex-1 p-4 flex flex-col gap-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center py-2.5 px-4 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt w-6 text-center ml-2"></i> لوحة التحكم
                </a>
                <a href="{{ route('admin.cars.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition-all {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">
                    <i class="fas fa-car w-6 text-center ml-2"></i> الإعلانات
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition-all {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-sitemap w-6 text-center ml-2"></i> التصنيفات
                </a>
                <a href="{{ route('cars.front.index') }}" target="_blank" class="flex items-center py-2.5 px-4 rounded-lg transition-all">
                    <i class="fas fa-eye w-6 text-center ml-2"></i> عرض الموقع
                </a>
            </nav> 
        </aside>

        <!-- Mobile Sidebar (منزلق) -->
        <div x-show="sidebarOpen" class="md:hidden" style="display: none;">
            <!-- Overlay خلفية -->
            <div @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/60 z-30"></div>

            <!-- القائمة الجانبية الفعلية -->
            <aside x-show="sidebarOpen" 
                   x-transition:enter="transition ease-in-out duration-300 transform"
                   x-transition:enter-start="translate-x-full"
                   x-transition:enter-end="translate-x-0"
                   x-transition:leave="transition ease-in-out duration-300 transform"
                   x-transition:leave-start="translate-x-0"
                   x-transition:leave-end="translate-x-full"
                   class="fixed inset-y-0 right-0 w-64 bg-primary text-white z-40 p-6 flex flex-col shadow-2xl">
                
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">القائمة</h2>
                    <button @click="sidebarOpen = false" class="text-2xl">&times;</button>
                </div>
                
                <nav class="flex-1 flex flex-col gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="py-2 px-4 rounded hover:bg-white/10 transition-all">لوحة التحكم</a>
                    <a href="{{ route('admin.cars.index') }}" class="py-2 px-4 rounded hover:bg-white/10 transition-all">الإعلانات</a>
                    <a href="{{ route('admin.categories.index') }}" class="py-2 px-4 rounded hover:bg-white/10 transition-all">التصنيفات</a>
                    <a href="{{ route('cars.front.index') }}" class="py-2 px-4 rounded hover:bg-white/10 transition-all">عرض السيارات</a>
                </nav>
            </aside>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="flex-1 flex flex-col">
            <!-- شريط علوي للجوال -->
            <header class="md:hidden flex items-center justify-between bg-white shadow-md p-4 sticky top-0 z-10">
                <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold text-primary hover-scale">لوحة التحكم</a>
                <button @click="sidebarOpen = true" class="p-2 text-primary hover-scale">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </header>

            <!-- منطقة المحتوى -->
            <main class="flex-1 p-4 md:p-8">
                @yield('content')
            </main>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    @stack('scripts')
</body>
</html>