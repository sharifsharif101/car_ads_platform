{{-- resources/views/layouts/public.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    {{-- سيتم استخدام العنوان من الصفحات التي سترث هذا التصميم --}}
    <title>@yield('title', 'سيارات ابو خالد')</title>

    {{-- لإضافة Tailwind CSS أو أي ملفات CSS أخرى تحتاجها في الواجهة الأمامية --}}
    {{--  تأكد من أن هذا المسار صحيح لمشروعك --}}
    @vite('resources/css/app.css') 

    {{-- Alpine.js for interactivity --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100">

    {{-- 1. الناف بار العلوي المطلوب --}}
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- لوقو سيارات ابو خالد --}}
<div class="flex-shrink-0">
    <a href="{{ route('cars.front.index') }}" class="text-2xl font-bold text-primary">
        سيارات ابو خالد
    </a>
</div>
                {{-- الروابط في الناف بار --}}
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        {{-- يمكنك إضافة روابط أخرى هنا إذا أردت مستقبلاً --}}

                        @auth
                            <!-- Dropdown Menu للمستخدم المسجل -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="flex items-center text-gray-700 hover:text-primary focus:outline-none">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                                     style="display: none;">
                                    <div class="py-1">
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">لوحة التحكم</a>
                                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">البروفايل</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                تسجيل الخروج
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- إذا كان المستخدم زائراً، تظهر أزرار تسجيل الدخول وإنشاء حساب --}}
                            <a href="{{ route('login') }}" 
                               class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                               تسجيل الدخول
                            </a>
                            {{-- <a href="{{ route('register') }}" 
                               class="bg-primary text-white hover:bg-primary/80 px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                               إنشاء حساب
                            </a> --}}
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    {{-- 2. المحتوى الرئيسي للصفحة --}}
    <main class="py-8">
        @yield('content')
    </main>

    {{-- هذا القسم لإضافة أي سكريبتات خاصة بصفحة معينة --}}
    @stack('scripts')
</body>
</html>