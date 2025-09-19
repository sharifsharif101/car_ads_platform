@extends('admin.layout')

@section('title', 'إدارة الإعلانات')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-semibold text-primary tracking-tight">إدارة الإعلانات</h1>
        <p class="mt-2 text-gray-600 max-w-2xl mx-auto">عرض وتعديل أو حذف الإعلانات الموجودة في النظام</p>
    </div>

@if (session('success'))
    <div 
        id="success-message" 
        class="mb-8 p-4 bg-green-50 text-green-700 border-l-4 border-green-500 rounded-lg shadow-sm animate-fadeIn"
    >
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const msg = document.getElementById('success-message');
            if (msg) {
                msg.style.transition = "opacity 0.5s ease";
                msg.style.opacity = 0;
                setTimeout(() => msg.remove(), 500); // يحذف العنصر بعد انتهاء التأثير
            }
        }, 2000); // بعد ثانيتين
    </script>
@endif


    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.cars.create') }}" 
           class="bg-accent hover:bg-accent/90 text-white px-5 py-2.5 rounded-lg shadow transition duration-300 transform hover:-translate-y-0.5">
            إضافة إعلان جديد
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-100">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-secondary text-white">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="py-3 px-4 text-right text-sm font-medium">#</th>
                    <th class="py-3 px-4 text-right text-sm font-medium">عنوان الإعلان</th>
                    <th class="py-3 px-4 text-right text-sm font-medium">السعر</th>
                    <th class="py-3 px-4 text-right text-sm font-medium">الحالة</th>
                    <th class="py-3 px-4 text-right text-sm font-medium">إجراءات</th>
                    <th class="py-3 px-4 text-right text-sm font-medium">صورة السيارة</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100 text-gray-700">
                @foreach($cars as $car)
                <tr class="hover:bg-lightbg transition-colors duration-200">
                    <td class="py-3 px-4 text-sm">{{ $car->id }}</td>
                    <td class="py-3 px-4 text-sm font-medium">{{ $car->title }}</td>
                    <td class="py-3 px-4 text-sm">{{ number_format($car->price) }} ريال</td>
                    <td class="py-3 px-4 text-sm">
                        @php
                            $statusClasses = [
                                'active' => 'bg-green-100 text-green-800',
                                'inactive' => 'bg-red-100 text-red-800',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'expired' => 'bg-gray-100 text-gray-800',
                            ];
                            $statusTranslations = [
                                'active' => 'نشط',
                                'inactive' => 'غير نشط',
                                'pending' => 'قيد المراجعة',
                                'expired' => 'منتهي',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusClasses[$car->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusTranslations[$car->status] ?? $car->status }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-sm space-x-2 flex gap-2">
                        <a href="{{ route('admin.cars.edit', $car) }}" 
                           class="bg-accent hover:bg-accent/90 text-white px-3 py-1.5 rounded shadow transition transform hover:-translate-y-0.5">
                            تعديل
                        </a>
                        <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" 
                              onsubmit="return confirm('هل أنت متأكد من رغبتك في الحذف؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded shadow transition transform hover:-translate-y-0.5">
                                حذف
                            </button>
                        </form>
                    </td>
                    <td class="py-3 px-4">
                        @if($car->main_image)
                            <img src="{{ Storage::url($car->main_image) }}" 
                                 alt="{{ $car->title }}" 
                                 class="w-16 h-12 object-cover rounded-md shadow-sm">
                        @else
                            <span class="text-gray-400 text-sm">لا توجد صورة</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $cars->links() }}
    </div>
</div>
@endsection