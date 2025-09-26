@extends('layouts.public')

@section('title', 'إعلانات السيارات')

@section('content')
<style>
    /* تم نقل تعريف الخط إلى ملف `tailwind.config.js` لتوحيد النمط */
    .microsoft-container {
        background-color: #F7F7F7;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .microsoft-input {
        border: 1px solid #C8C6C4;
        border-radius: 4px;
        padding: 8px 12px;
        transition: border-color 0.2s;
        background-color: white;
    }
    
    .microsoft-input:focus {
        outline: none;
        border-color: #3338A0;
        box-shadow: 0 0 0 1px #3338A0;
    }
    
    .microsoft-button {
        background-color: #3338A0;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .microsoft-button:hover {
        background-color: #272c85;
    }
    
    .microsoft-divider {
        background-color: #E5E5E5;
        height: 1px;
        margin: 16px 0;
    }
    
    .reset-link {
        color: #C59560;
        text-decoration: none;
    }
    
    .reset-link:hover {
        color: #3338A0;
        text-decoration: underline;
    }
    
    .price-text {
        color: #3338A0;
        font-weight: bold;
        font-size: 1.125rem;
    }
    
    .category-tag {
        background-color: white;
        border: 1px solid #E5E5E5;
        color: #333333;
    }

    .custom-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: left 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-left: 2.5rem; 
    }

    .unavailable-ribbon {
        position: absolute;
        background: #dc2626;
        color: white;
        text-align: center;
        font-weight: bold;
        padding: 8px 0;
        box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        top: 25px;
        left: -35px;
        width: 150px;
        transform: rotate(-45deg);
        font-size: 0.8rem;
        z-index: 10;
    }

    @media (min-width: 768px) {
        .unavailable-ribbon {
            font-size: 1rem;
        }
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <h1 class="text-3xl md:text-4xl font-semibold text-gray-900 mb-6">إعلانات السيارات</h1>

    <!-- Search & Filters -->
    <form method="GET" action="{{ route('cars.front.index') }}" class="microsoft-container p-5 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-5">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="ابحث عن عنوان أو وصف"
                class="microsoft-input col-span-1 md:col-span-2"
            />
            <input
                type="number"
                name="min_price"
                value="{{ request('min_price') }}"
                placeholder="أقل سعر"
                class="microsoft-input"
            />
            <input
                type="number"
                name="max_price"
                value="{{ request('max_price') }}"
                placeholder="أعلى سعر"
                class="microsoft-input"
            />
        </div>

        <div class="microsoft-divider"></div>

        <h3 class="text-lg font-medium text-gray-800 mb-3">تصفية حسب المواصفات</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($categories as $category)
                <div>
                    <label for="category_{{ $category->id }}" class="block text-xs font-medium text-gray-600 mb-1">
                        {{ $category->name }}
                    </label>
                    <select
                        name="category_values[{{ $category->id }}]"
                        id="category_{{ $category->id }}"
                        class="microsoft-input w-full custom-select"
                    >
                        <option value="">الكل</option>
                        @foreach($category->values as $value)
                            <option value="{{ $value->id }}" @selected(request("category_values.{$category->id}") == $value->id)>
                                {{ $value->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end items-center mt-5 gap-3">
            <a href="{{ route('cars.front.index') }}" class="reset-link text-sm font-medium transition">
                إعادة التعيين
            </a>
            <button type="submit" class="microsoft-button">
                تصفية
            </button>
        </div>
    </form>

    <!-- Car Listings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse($cars as $car)
            <a href="{{ $car->status === 'active' ? route('cars.front.show', $car) : '#' }}" class="group block microsoft-container overflow-hidden car-card">
                <!-- Mobile Layout -->
                <div class="md:hidden flex items-center p-3 space-x-3">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-gray-900 mb-1 truncate">{{ $car->title }}</h3>
                        <div class="price-text mb-1">{{ number_format($car->price, 0) }} ريال</div>
                        <p class="text-xs text-gray-600 line-clamp-2">{{ Str::limit($car->description, 60) }}</p>
                        {{-- إضافة التصنيفات في عرض الجوال --}}
                        @if($car->categoryValues->isNotEmpty())
                            <div class="mt-2 flex flex-wrap gap-1">
                                @foreach($car->categoryValues->take(2) as $val) {{-- عرض أول تصنيفين فقط لتوفير المساحة --}}
                                    <span class="category-tag px-1.5 py-0.5 rounded text-[10px]">
                                        {{ $val->value }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="relative w-20 h-20 bg-white rounded-lg overflow-hidden flex-shrink-0 border">
                        @if($car->main_image)
                            <img src="{{ asset('uploads/' . $car->main_image) }}"
                                 alt="{{ $car->title }}"
                                 class="object-contain w-full h-full {{ $car->status !== 'active' ? 'filter grayscale' : '' }}" />
                        @elseif($car->images->first())
                            <img src="{{ asset('uploads/' . $car->images->first()->image_path) }}"
                                 alt="{{ $car->title }}"
                                 class="object-contain w-full h-full {{ $car->status !== 'active' ? 'filter grayscale' : '' }}" />
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs {{ $car->status !== 'active' ? 'filter grayscale' : '' }}">
                                لا صورة
                            </div>
                        @endif
                        @if ($car->status !== 'active')
                            <div class="unavailable-ribbon">غير متوفرة</div>
                        @endif
                    </div>
                </div>

                <!-- Desktop Layout -->
                <div class="hidden md:block">
                    <div class="relative w-full aspect-square bg-white overflow-hidden border-b">
                        @if($car->main_image)
                            <img src="{{ asset('uploads/' . $car->main_image) }}"
                                 alt="{{ $car->title }}"
                                 class="object-contain w-full h-full transition-transform duration-500 group-hover:scale-105 {{ $car->status !== 'active' ? 'filter grayscale' : '' }}" />
                        @elseif($car->images->first())
                            <img src="{{ asset('uploads/' . $car->images->first()->image_path) }}"
                                 alt="{{ $car->title }}"
                                 class="object-contain w-full h-full transition-transform duration-500 group-hover:scale-105 {{ $car->status !== 'active' ? 'filter grayscale' : '' }}" />
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm {{ $car->status !== 'active' ? 'filter grayscale' : '' }}">
                                لا توجد صورة
                            </div>
                        @endif
                        @if ($car->status !== 'active')
                            <div class="unavailable-ribbon">غير متوفرة</div>
                        @endif
                    </div>

                    <div class="p-4 flex flex-col h-full">
                        <h3 class="text-base font-semibold text-gray-900 mb-1 truncate">{{ $car->title }}</h3>
                        <p class="text-xs text-gray-600 line-clamp-2 mb-2">{{ Str::limit($car->description, 80) }}</p>
                        <div class="price-text mb-2">{{ number_format($car->price, 0) }} ريال</div>

                        @if($car->categoryValues->isNotEmpty())
                            <div class="text-xs text-gray-600 mt-2 flex flex-wrap gap-1">
                                @foreach($car->categoryValues as $val)
                                    <span class="category-tag px-2 py-1 rounded text-xs">
                                        {{ $val->value }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-10 text-gray-500">
                لا توجد نتائج مطابقة.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $cars->links() }}
    </div>

</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/scrollreveal"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    ScrollReveal().reveal('.car-card', {
      duration: 800,       // مدة الانيميشن (ms)
      distance: '50px',    // المسافة اللي يتحرك منها العنصر
      origin: 'bottom',    // من أين يبدأ (bottom, top, left, right)
      easing: 'ease-in-out',
      interval: 100        // يخلي العناصر تظهر وحدة وراء الثانية
    });
  });
</script>
