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
            class="mb-8 p-4 bg-green-50 text-green-700 border-l-4 border-green-500 rounded-lg shadow-sm animate-fadeIn opacity-100 transition-opacity duration-500"
        >
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const msg = document.getElementById('success-message');
                if (msg) {
                    msg.classList.add('opacity-0');
                    setTimeout(() => msg.remove(), 500);
                }
            }, 2000);
        </script>
    @endif

    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.cars.create') }}" 
           class="bg-accent hover:bg-accent-dark text-black px-5 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 inline-flex items-center">
            <span>إضافة إعلان جديد</span>
        </a>
    </div>

    <!-- Desktop/Tablet: Table View -->
    <div class="hidden md:block bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-secondary text-black">
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
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-3 px-4 text-sm font-medium">{{ $car->id }}</td>
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
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClasses[$car->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusTranslations[$car->status] ?? $car->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-sm space-x-2 flex gap-2">
                            <a href="{{ route('admin.cars.edit', $car) }}" 
                               class="bg-accent hover:bg-accent-dark text-black px-3 py-1.5 rounded shadow hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                                تعديل
                            </a>
                            <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" 
                                  onsubmit="return confirm('هل أنت متأكد من رغبتك في الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-black px-3 py-1.5 rounded shadow hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                                    حذف
                                </button>
                            </form>
                        </td>
                        <td class="py-3 px-4">
                            @if($car->main_image)
                                 <img src="{{ asset('uploads/' . $car->main_image) }}"
                                     alt="{{ $car->title }}" 
                                     class="w-16 h-12 object-cover rounded shadow-sm">
                            @else
                                <span class="text-gray-400 text-sm">لا توجد صورة</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile: Cards View -->
 
<!-- Mobile & Tablet: WhatsApp-Style Cards -->
<div class="md:hidden space-y-2 pb-4">
    @foreach($cars as $car)
    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-4 gap-4">
            
            <!-- Avatar / Image Circle -->
            <div class="shrink-0">
                @if($car->main_image)
                      <img src="{{ asset('uploads/' . $car->main_image) }}"
                         alt="{{ $car->title }}" 
                         class="w-16 h-16 rounded-full object-cover border border-gray-200 shadow-sm">
                @else
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center border border-gray-200">
                        <span class="text-gray-500 font-bold text-xl">🚗</span>
                    </div>
                @endif
            </div>

            <!-- Name & Description -->
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-gray-800 text-base leading-snug truncate">
                    {{ $car->title }}
                </h3>
                <p class="text-sm text-gray-600 mt-1 truncate">
                    {{ number_format($car->price) }} ريال    
                </p>

                <!-- Status Badge -->
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-medium {{ $statusClasses[$car->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $statusTranslations[$car->status] ?? $car->status }}
                </span>
            </div>

            <!-- Action Buttons -->
            <div class="shrink-0 flex flex-col gap-2">
                <a href="{{ route('admin.cars.edit', $car) }}" 
                   class="w-10 h-10 flex items-center justify-center bg-accent hover:bg-accent-dark text-black rounded-lg shadow-sm hover:shadow transition-all duration-200"
                   title="تعديل">
                    ✏️
                </a>
                <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="inline-block"
                      onsubmit="return confirm('هل أنت متأكد من رغبتك في الحذف؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-10 h-10 flex items-center justify-center bg-red-500 hover:bg-red-600 text-black rounded-lg shadow-sm hover:shadow transition-all duration-200"
                            title="حذف">
                        🗑️
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>


    <div class="mt-8">
        {{ $cars->links() }}
    </div>
</div>
@endsection