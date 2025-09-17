{{-- resources/views/layouts/public.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    {{-- سيتم استخدام العنوان من الصفحات التي سترث هذا التصميم --}}
    <title>@yield('title', 'سيارات ابو خالد')</title>

    {{-- لإضافة Tailwind CSS أو أي ملفات CSS أخرى تحتاجها في الواجهة الأمامية --}}
    {{--  تأكد من أن هذا المسار صحيح لمشروعك --}}
    @vite('resources/css/app.css') 
</head>
<body class="bg-gray-100">

    {{-- 1. الناف بار العلوي المطلوب --}}
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- لوقو سيارات ابو خالد --}}
                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-bold text-primary">
                        سيارات ابو خالد
                    </a>
                </div>

                {{-- يمكنك إضافة روابط أخرى هنا إذا أردت مستقبلاً --}}
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        {{-- <a href="#" class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-sm font-medium">الرئيسية</a> --}}
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