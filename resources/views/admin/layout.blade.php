<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

</head>
<body class="bg-lightbg text-gray-800">

    <div x-data="{ open: false }" class="flex min-h-screen">

        <!-- Sidebar for Desktop -->
   <aside class="hidden md:flex w-64 flex-col bg-primary text-white">
    <div class="p-6 text-2xl font-bold border-b border-primary/80">Admin Panel</div>
    
    <nav class="flex-1 p-4 flex flex-col gap-2">
        <a href="{{ route('admin.dashboard') }}" 
           class="py-2 px-4 rounded transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-accent' : 'hover:bg-primary/80' }}">
            لوحة التحكم
        </a>

        <a href="{{ route('admin.cars.index') }}" 
           class="py-2 px-4 rounded transition-colors {{ request()->routeIs('admin.cars.*') ? 'bg-accent' : 'hover:bg-primary/80' }}">
            الإعلانات
        </a>

        <a href="{{ route('admin.categories.index') }}" 
           class="py-2 px-4 rounded transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-accent' : 'hover:bg-primary/80' }}">
            التصنيفات
        </a>

        {{-- تم تفعيل هذا الرابط --}}
        <a href="{{ route('admin.tags.index') }}" 
           class="py-2 px-4 rounded transition-colors {{ request()->routeIs('admin.tags.*') ? 'bg-accent' : 'hover:bg-primary/80' }}">
            الوسوم
        </a>

         {{-- <a href="{{ route('admin.users.index') }}" 
           class="py-2 px-4 rounded transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-accent' : 'hover:bg-primary/80' }}">
            المستخدمين
        </a> --}}
    </nav> 
</aside>

        <!-- Mobile Sidebar Toggle -->
        <div class="md:hidden">
            <!-- زر الفتح -->
            <button @click="open = true" class="m-4 p-2 bg-primary text-white rounded">☰ القائمة</button>

            <!-- Overlay خلفية -->
            <div x-show="open" class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

            <!-- Drawer Sidebar -->
            <aside x-show="open" x-transition class="fixed inset-y-0 right-0 w-64 bg-primary text-white z-50 p-6 flex flex-col">
                <button @click="open = false" class="self-end text-2xl mb-4">✕</button>
                {{-- <nav class="flex-1 flex flex-col gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="py-2 px-4 rounded hover:bg-primary/80">Dashboard</a>
                    <a href="{{ route('admin.cars.index') }}" class="py-2 px-4 rounded hover:bg-primary/80">الإعلانات</a>
                    <a href="{{ route('admin.categories.index') }}" class="py-2 px-4 rounded hover:bg-primary/80">التصنيفات</a>
                    <a href="{{ route('admin.tags.index') }}" class="py-2 px-4 rounded hover:bg-primary/80">الوسوم</a>
                    <a href="{{ route('admin.users.index') }}" class="py-2 px-4 rounded hover:bg-primary/80">المستخدمين</a>
                </nav> --}}
            </aside>
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    @stack('scripts')

</body>
</html>
