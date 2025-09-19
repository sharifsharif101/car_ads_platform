@extends('layouts.public')

@section('title', 'إعلانات السيارات')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
    }
    
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
                        class="microsoft-input w-full"
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
            <a href="{{ route('cars.front.show', $car) }}" class="group block microsoft-container overflow-hidden">
                <!-- Mobile Layout: Image on right, text on left -->
                <div class="md:hidden flex items-center p-3 space-x-3">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-gray-900 mb-1 truncate">{{ $car->title }}</h3>
                        <div class="price-text mb-1">{{ number_format($car->price, 0) }} ريال</div>
                        <p class="text-xs text-gray-600 line-clamp-2">{{ Str::limit($car->description, 60) }}</p>
                    </div>
                    <div class="relative w-20 h-20 bg-white rounded-lg overflow-hidden flex-shrink-0 border">
                        @if($car->main_image)
                            <img src="{{ Storage::url($car->main_image) }}" alt="{{ $car->title }}" class="object-cover w-full h-full"/>
                        @elseif($car->images->first())
                            <img src="{{ Storage::url($car->images->first()->image_path) }}" alt="{{ $car->title }}" class="object-cover w-full h-full"/>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                                لا صورة
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Desktop Layout: Image on top, text below (4-column grid) -->
                <div class="hidden md:block">
                    <div class="relative w-full aspect-square bg-white overflow-hidden border-b">
                        @if($car->main_image)
                            <img src="{{ Storage::url($car->main_image) }}" alt="{{ $car->title }}" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105"/>
                        @elseif($car->images->first())
                            <img src="{{ Storage::url($car->images->first()->image_path) }}" alt="{{ $car->title }}" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105"/>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                                لا توجد صورة
                            </div>
                        @endif
                    </div>

                    <div class="p-4 flex flex-col h-full">
                        <h3 class="text-base font-semibold text-gray-900 mb-1 truncate">{{ $car->title }}</h3>
                        <p class="text-xs text-gray-600 line-clamp-2 mb-2">{{ Str::limit($car->description, 80) }}</p>
                        <div class="price-text mb-2">{{ number_format($car->price, 0) }} ريال</div>

                        @if($car->categoryValues->isNotEmpty())
                            <div class="text-xs text-gray-600 mt-auto space-y-1">
                                @foreach($car->categoryValues as $val)
                                    <span class="inline-block mr-1 category-tag px-2 py-1 rounded text-xs">
                                        {{ $val->category?->name }}: {{ $val->value }}
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