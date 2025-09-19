<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم')</title>
    
    {{-- Vite directive for CSS and JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- External CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
    {{-- Alpine.js for interactivity --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    
 
</head>
<body class="bg-gray-100 text-gray-800">

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">

        <!-- Sidebar للـ Desktop (ثابت) -->
        <aside class="hidden md:flex w-64 flex-col bg-primary text-white shadow-lg">
            <div class="p-6 text-2xl font-bold border-b border-primary/80">
                <a href="{{ route('admin.dashboard') }}">لوحة التحكم</a>
            </div>
            
            <nav class="flex-1 p-4 flex flex-col gap-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center py-2.5 px-4 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-accent' : 'hover:bg-primary/80' }}">
                    <i class="fas fa-tachometer-alt w-6 text-center ml-2"></i> لوحة التحكم
                </a>
                <a href="{{ route('admin.cars.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition-colors {{ request()->routeIs('admin.cars.*') ? 'bg-accent' : 'hover:bg-primary/80' }}">
                    <i class="fas fa-car w-6 text-center ml-2"></i> الإعلانات
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center py-2.5 px-4 rounded-lg transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-accent' : 'hover:bg-primary/80' }}">
                    <i class="fas fa-sitemap w-6 text-center ml-2"></i> التصنيفات
                </a>
                <a href="{{ route('cars.front.index') }}" target="_blank" class="flex items-center py-2.5 px-4 rounded-lg transition-colors hover:bg-primary/80">
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
                    <a href="{{ route('admin.dashboard') }}" class="py-2 px-4 rounded hover:bg-primary/80">لوحة التحكم</a>
                    <a href="{{ route('admin.cars.index') }}" class="py-2 px-4 rounded hover:bg-primary/80">الإعلانات</a>
                    <a href="{{ route('admin.categories.index') }}" class="py-2 px-4 rounded hover:bg-primary/80">التصنيفات</a>
                    <a href="{{ route('cars.front.index') }}" class="py-2 px-4 rounded hover:bg-primary/80">عرض السيارات</a>
                </nav>
            </aside>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="flex-1 flex flex-col">
            <!-- شريط علوي للجوال -->
            <header class="md:hidden flex items-center justify-between bg-white shadow-md p-4 sticky top-0 z-10">
                <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold text-primary">لوحة التحكم</a>
                <button @click="sidebarOpen = true" class="p-2 text-primary">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </header>

            <!-- منطقة المحتوى -->
            <main class="flex-1 p-4 md:p-8">
                @yield('content')
            </main>
        </div>

    </div>

    {{-- External JS --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    @stack('scripts')
  
</body>
</html>