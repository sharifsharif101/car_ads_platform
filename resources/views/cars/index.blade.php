@extends('layouts.public')

@section('title', 'إعلانات السيارات')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Header -->
    <h1 class="text-3xl md:text-4xl font-semibold text-primary mb-8 tracking-tight">إعلانات السيارات</h1>

    <!-- Search & Filters -->
    <form method="GET" action="{{ route('cars.front.index') }}" class="bg-white rounded-xl shadow-sm p-6 mb-10 transition-all hover:shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="ابحث عن عنوان أو وصف"
                class="border border-gray-200 rounded-lg p-3 text-sm focus:ring-2 focus:ring-accent focus:border-transparent col-span-1 md:col-span-2"
            />
            <input
                type="number"
                name="min_price"
                value="{{ request('min_price') }}"
                placeholder="أقل سعر"
                class="border border-gray-200 rounded-lg p-3 text-sm focus:ring-2 focus:ring-accent focus:border-transparent"
            />
            <input
                type="number"
                name="max_price"
                value="{{ request('max_price') }}"
                placeholder="أعلى سعر"
                class="border border-gray-200 rounded-lg p-3 text-sm focus:ring-2 focus:ring-accent focus:border-transparent"
            />
            <select name="tag" class="border border-gray-200 rounded-lg p-3 text-sm focus:ring-2 focus:ring-accent focus:border-transparent">
                <option value="">كل الوسوم</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->name }}" @selected(request('tag') === $tag->name)>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <hr class="my-6 border-gray-100">

        <h3 class="text-lg font-medium text-gray-800 mb-4">تصفية حسب المواصفات</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($categories as $category)
                <div>
                    <label for="category_{{ $category->id }}" class="block text-xs font-medium text-gray-500 mb-1">
                        {{ $category->name }}
                    </label>
                    <select
                        name="category_values[{{ $category->id }}]"
                        id="category_{{ $category->id }}"
                        class="w-full border border-gray-200 rounded-lg p-2 text-sm focus:ring-2 focus:ring-accent focus:border-transparent"
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

        <div class="flex justify-end mt-6">
            <button class="bg-accent hover:bg-opacity-90 text-primary px-6 py-2.5 rounded-lg transition duration-200 ease-in-out transform hover:-translate-y-0.5 shadow hover:shadow-md font-medium">
                تصفية
            </button>
        </div>
    </form>

    <!-- Car Listings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($cars as $car)
            <a href="{{ route('cars.front.show', $car) }}" class="group block bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 md:hover:-translate-y-1">
                <!-- Mobile Layout: Image on right, text on left -->
                <div class="md:hidden flex items-center p-4 space-x-4">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-semibold text-primary mb-1 truncate">{{ $car->title }}</h3>
                        <div class="text-accent font-bold text-lg mb-2">{{ number_format($car->price, 0) }} ريال</div>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($car->description, 80) }}</p>
                    </div>
                    <div class="relative w-24 h-24 bg-lightbg rounded-lg overflow-hidden flex-shrink-0">
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
                    <div class="relative w-full aspect-square bg-lightbg overflow-hidden">
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

                    <div class="p-5 flex flex-col h-full">
                        <h3 class="text-lg font-semibold text-primary mb-1 truncate">{{ $car->title }}</h3>
                        <p class="text-sm text-gray-600 line-clamp-2 mb-3">{{ Str::limit($car->description, 100) }}</p>
                        <div class="text-accent font-bold text-lg mb-3">{{ number_format($car->price, 0) }} ريال</div>

                        @if($car->tags->isNotEmpty())
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($car->tags as $tag)
                                    <span class="bg-lightbg text-secondary text-xs px-2 py-1 rounded">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if($car->categoryValues->isNotEmpty())
                            <div class="text-xs text-gray-500 mt-auto space-y-1">
                                @foreach($car->categoryValues as $val)
                                    <span class="inline-block mr-1 bg-lightbg px-2 py-1 rounded text-secondary">
                                        {{ $val->category?->name }}: {{ $val->value }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                لا توجد نتائج مطابقة.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-10">
        {{ $cars->links() }}
    </div>

</div>
@endsection