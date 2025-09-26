{{-- غيرنا 'admin.layout' إلى 'layouts.public' --}}
@extends('layouts.public')

@section('title', $car->title)

@section('content')
{{-- تم حذف "py-8" من هنا لضبط المسافة --}}
<div class="container mx-auto "  >
    <div class="bg-white p-6 rounded-lg shadow-lg" style="margin-top: 50px;">

        <h1 class="text-3xl font-bold text-primary mb-2">{{ $car->title }}</h1>
        <div class="text-2xl text-accent font-bold mb-6">{{ number_format($car->price, 0) }} ريال</div>

        {{-- باقي الكود يبقى كما هو --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="md:col-span-2">
                @if($car->main_image)
                    <img id="mainImage" src="{{ Storage::url($car->main_image) }}" alt="{{ $car->title }}" class="w-full h-auto max-h-[500px] object-cover rounded-lg shadow"/>
                @elseif($car->images->isNotEmpty())
                     <img id="mainImage" src="{{ Storage::url($car->images->first()->image_path) }}" alt="{{ $car->title }}" class="w-full h-auto max-h-[500px] object-cover rounded-lg shadow"/>
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400 rounded-lg">لا توجد صورة</div>
                @endif
            </div>

            @if($car->images->count() > 1 || ($car->main_image && $car->images->isNotEmpty()))
            <div class="flex flex-row md:flex-col gap-2 overflow-x-auto md:overflow-y-auto">
                 @if($car->main_image)
                    <img src="{{ Storage::url($car->main_image) }}" class="thumbnail w-24 h-24 md:w-full md:h-24 object-cover rounded cursor-pointer border-2 border-accent" onclick="document.getElementById('mainImage').src='{{ Storage::url($car->main_image) }}'">
                 @endif
                @foreach($car->images as $image)
                    <img src="{{ Storage::url($image->image_path) }}" class="thumbnail w-24 h-24 md:w-full md:h-24 object-cover rounded cursor-pointer border-2 border-transparent hover:border-accent" onclick="document.getElementById('mainImage').src='{{ Storage::url($image->image_path) }}'">
                @endforeach
            </div>
            @endif
        </div>

        <div class="prose max-w-none mb-6 text-gray-700">
            <h3 class="text-xl font-semibold text-primary mb-2">الوصف</h3>
            <p>{!! nl2br(e($car->description)) !!}</p>
        </div>

        @if($car->categoryValues->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-xl font-semibold text-primary mb-3">التفاصيل</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    @foreach($car->categoryValues as $val)
                        <div class="flex justify-between items-center py-2 border-b last:border-b-0">
                            <span class="font-semibold text-gray-600">{{ $val->category?->name }}</span>
                            <span class="text-gray-800">{{ $val->value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection