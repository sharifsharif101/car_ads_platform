@extends('admin.layout')
@section('title', 'تعديل الإعلان: ' . $car->title)
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800" style="font-family: 'Google Sans', Roboto, sans-serif;">تعديل الإعلان: <span class="font-normal text-[#4285F4]">{{ $car->title }}</span></h1>
        <a href="{{ route('admin.cars.index') }}" class="bg-white text-gray-700 px-5 py-2.5 rounded-full shadow-md hover:shadow-lg transition-all duration-200 flex items-center border border-gray-200">
            <i class="fa fa-arrow-left ml-2"></i>
            العودة إلى القائمة
        </a>
    </div>

{{-- عرض أخطاء التحقق من المدخلات --}}
@if ($errors->any())
    <div class="bg-red-50 border-l-4 border-[#EA4335] text-[#EA4335] p-5 mb-6 rounded-xl shadow-sm" role="alert">
        <p class="font-bold text-lg">حدث خطأ!</p>
        <ul class="mt-3 list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.cars.update', $car) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl shadow-md space-y-8">
    @csrf
    @method('PUT')

    {{-- القسم الرئيسي للمعلومات --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- عنوان الإعلان --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Google Sans', Roboto, sans-serif;">عنوان الإعلان <span class="text-[#EA4335]">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title', $car->title) }}" class="w-full border border-[#DADCE0] rounded-xl shadow-sm focus:border-[#4285F4] focus:ring-2 focus:ring-[#4285F4]/20 py-3 px-4 transition-all duration-200" required>
        </div>

        {{-- السعر --}}
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Google Sans', Roboto, sans-serif;">السعر (ريال) <span class="text-[#EA4335]">*</span></label>
            <input type="number" id="price" name="price" value="{{ old('price', $car->price) }}" class="w-full border border-[#DADCE0] rounded-xl shadow-sm focus:border-[#4285F4] focus:ring-2 focus:ring-[#4285F4]/20 py-3 px-4 transition-all duration-200" required>
        </div>

        {{-- الحالة --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Google Sans', Roboto, sans-serif;">الحالة <span class="text-[#EA4335]">*</span></label>
            <select id="status" name="status" 
        class="w-full border border-[#DADCE0] rounded-xl shadow-sm focus:border-[#4285F4] focus:ring-2 focus:ring-[#4285F4]/20 py-3 pl-10 pr-4 transition-all duration-200 appearance-none bg-white 
               bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAiIGhlaWdodD0iNiIgdmlld0JveD0iMCAwIDEwIDYiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTguNTg1NzkgMC4yOTI4OTNDOS4wNzY5MiAwLjc4NDAyMSA5LjA3NjkyIDEuNTgwNTUgOC41ODU3OSAyLjA3MTY4TDUuNDE0MjEgNC45Mjg5M0M1LjAyNzQ0IDUuMzE1NzEgNC4zOTQxMSA1LjMxNTcxIDQuMDA3MzMgNC45Mjg5M0wxLjQxNDIxIDIuMDcxNjhDMS4wMjMwOSAxLjU4MDU1IDEuMDIzMDkgMC43ODQwMjEgMS40MTQyMSAwLjI5Mjg5M0MyLjE5NjUxIC0wLjQ4OTQwOSAzLjQ2OTg1IC0wLjQ4OTQwOSA0LjI1MjE1IDAuMjkyODkzTDUgMS4wNDUwNEw1Ljc0Nzg1IDAuMjkyODkzQzYuNTMwMTUgLTAuNDg5NDA5IDcuODAzNDkgLTAuNDg5NDA5IDguNTg1NzkgMC4yOTI4OTNaIiBmaWxsPSIjNjE2MTYxIi8+PC9zdmc+')] 
               bg-no-repeat bg-[left_1rem_center]">
    <option value="active" @selected(old('status', $car->status) == 'active')>نشط</option>
    <option value="inactive" @selected(old('status', $car->status) == 'inactive')>غير نشط</option>
    <option value="pending" @selected(old('status', $car->status) == 'pending')>قيد المراجعة</option>
    <option value="expired" @selected(old('status', $car->status) == 'expired')>منتهي</option>
</select>
            <div class="mt-2 text-xs text-gray-500 space-y-1 pr-2">
                <p><strong>نشط:</strong> يظهر بشكل طبيعي للزوار. ✅</p>
                <p><strong>غير نشط:</strong> يظهر مع تنويه (غير متوفر). ✅</p>
                <p><strong>قيد المراجعة:</strong> لا يظهر للزوار، للمراجعة فقط. ❌</p>
                <p><strong>منتهي:</strong> لا يظهر نهائيًا في الموقع. ❌</p>
            </div>

        </div>
    </div>

    {{-- الوصف --}}
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Google Sans', Roboto, sans-serif;">الوصف</label>
        <textarea id="description" name="description" rows="5" class="w-full border border-[#DADCE0] rounded-xl shadow-sm focus:border-[#4285F4] focus:ring-2 focus:ring-[#4285F4]/20 py-3 px-4 transition-all duration-200">{{ old('description', $car->description) }}</textarea>
    </div>

    <div class="border-t border-gray-200 my-8"></div>

    {{-- قسم التصنيفات --}}
    <div>
        <h2 class="text-2xl font-bold mb-6 text-gray-800" style="font-family: 'Google Sans', Roboto, sans-serif;">التصنيفات</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                    <label for="category_{{ $category->id }}" class="block text-sm font-medium text-gray-700 mb-3" style="font-family: 'Google Sans', Roboto, sans-serif;">{{ $category->name }}</label>
                   <select name="categories[{{ $category->id }}]" 
        id="category_{{ $category->id }}" 
        class="w-full border border-[#DADCE0] rounded-xl shadow-sm focus:border-[#4285F4] focus:ring-2 focus:ring-[#4285F4]/20 py-3 px-4 transition-all duration-200 appearance-none bg-white bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAiIGhlaWdodD0iNiIgdmlld0JveD0iMCAwIDEwIDYiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTguNTg1NzkgMC4yOTI4OTNDOS4wNzY5MiAwLjc4NDAyMSA5LjA3NjkyIDEuNTgwNTUgOC41ODU3OSAyLjA3MTY4TDUuNDE0MjEgNC45Mjg5M0M1LjAyNzQ0IDUuMzE1NzEgNC4zOTQxMSA1LjMxNTcxIDQuMDA3MzMgNC45Mjg5M0wxLjQxNDIxIDIuMDcxNjhDMS4wMjMwOSAxLjU4MDU1IDEuMDIzMDkgMC43ODQwMjEgMS40MTQyMSAwLjI5Mjg5M0MyLjE5NjUxIC0wLjQ4OTQwOSAzLjQ2OTg1IC0wLjQ4OTQwOSA0LjI1MjE1IDAuMjkyODkzTDUgMS4wNDUwNEw1Ljc0Nzg1IDAuMjkyODkzQzYuNTMwMTUgLTAuNDg5NDA5IDcuODAzNDkgLTAuNDg5NDA5IDguNTg1NzkgMC4yOTI4OTNaIiBmaWxsPSIjNjE2MTYxIi8+PC9zdmc+')] 
        bg-no-repeat 
        bg-[left_1rem_center]">
    <option value="" class="text-black">-- اختر --</option>
    @foreach($category->categoryValues as $value)
        @php
            $selectedValue = $car->categoryValues->where('category_id', $category->id)->first()->id ?? null;
        @endphp
        <option value="{{ $value->id }}" @selected(old('categories.'.$category->id, $selectedValue) == $value->id)>{{ $value->value }}</option>
    @endforeach
</select>

                </div>
            @endforeach
        </div>
    </div>

    <div class="border-t border-gray-200 my-8"></div>

    {{-- قسم الصور --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- الصورة الأساسية --}}
        <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
            <h3 class="text-xl font-bold mb-4 text-gray-800" style="font-family: 'Google Sans', Roboto, sans-serif;">الصورة الأساسية</h3>
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-3" style="font-family: 'Google Sans', Roboto, sans-serif;">الصورة الحالية</label>
                @if($car->main_image)
                    <img src="{{ Storage::url($car->main_image) }}" alt="الصورة الأساسية" class="w-36 h-36 object-cover rounded-xl shadow-md border border-gray-200">
                @else
                    <div class="w-36 h-36 bg-gray-100 rounded-xl flex items-center justify-center border-2 border-dashed border-gray-300">
                        <span class="text-gray-400 text-sm">لا توجد صورة</span>
                    </div>
                @endif
            </div>
            <div>
                <label for="main_image" class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Google Sans', Roboto, sans-serif;">تغيير الصورة الأساسية (اختياري)</label>
                <input type="file" id="main_image" name="main_image" class="w-full border border-[#DADCE0] p-3 rounded-xl file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#4285F4] file:text-white hover:file:bg-[#3367d6] transition-all duration-200">
            </div>
        </div>

        {{-- الصور الإضافية --}}
        <div class="bg-green-50 p-6 rounded-2xl border border-green-100">
            <h3 class="text-xl font-bold mb-4 text-gray-800" style="font-family: 'Google Sans', Roboto, sans-serif;">الصور الإضافية</h3>
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-3" style="font-family: 'Google Sans', Roboto, sans-serif;">الصور الحالية</label>
                @if($car->images->isNotEmpty())
                    <div class="flex flex-wrap gap-4">
                        @foreach($car->images as $image)
                            <div class="relative group">
                                <img src="{{ Storage::url($image->image_path) }}" alt="صورة إضافية" class="w-28 h-28 object-cover rounded-xl shadow-md border border-gray-200">
                                <button type="submit" form="delete-image-{{ $image->id }}" onclick="return confirm('هل أنت متأكد من رغبتك في حذف هذه الصورة؟');" class="absolute -top-2 -right-2 bg-[#EA4335] text-white rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold opacity-0 group-hover:opacity-100 transition-all duration-200 shadow-md">&times;</button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-xl p-4 border border-dashed border-gray-300">
                        <p class="text-gray-500 text-center">لا توجد صور إضافية</p>
                    </div>
                @endif
            </div>
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Google Sans', Roboto, sans-serif;">إضافة صور جديدة (اختياري)</label>
                <input type="file" id="images" name="images[]" multiple class="w-full border border-[#DADCE0] p-3 rounded-xl file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#34A853] file:text-white hover:file:bg-[#2c8e49] transition-all duration-200">
                <div id="images_preview" class="flex flex-wrap gap-4 mt-4"></div>
            </div>
        </div>
    </div>

    {{-- زر التحديث --}}
    <div class="mt-10 pt-8 border-t border-gray-200 flex justify-end">
        <button type="submit" class="bg-[#4285F4] text-white px-8 py-3.5 rounded-full hover:bg-[#3367d6] transition-all duration-200 font-semibold shadow-md hover:shadow-lg flex items-center">
            <i class="fa fa-save mr-2"></i>
            تحديث الإعلان
        </button>
    </div>
</form>

{{-- نماذج حذف مخفية خارج نموذج التعديل لمنع تداخل النماذج --}}
@foreach($car->images as $image)
    <form id="delete-image-{{ $image->id }}" action="{{ route('admin.cars.images.destroy', $image) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endforeach
</div>
@push('scripts')
<script>
    // تهيئة مكتبة TomSelect لحقل الوسوم
    document.addEventListener('DOMContentLoaded', function () {
        new TomSelect('#tags',{
            persist: false,
            createOnBlur: true,
            create: true, // السماح بإضافة وسوم جديدة
            plugins: ['remove_button'],
            // إضافة الوسوم المحفوظة مسبقًا إلى الحقل
            items: {!! json_encode($car->tags->pluck('name')) !!}
        });

        // سكريبت معاينة الصور الإضافية الجديدة
        const imagesInput = document.getElementById('images');
        const imagesPreviewContainer = document.getElementById('images_preview');

        imagesInput.addEventListener('change', function(event) {
            imagesPreviewContainer.innerHTML = ''; // إفراغ الحاوية عند كل تغيير
            if (event.target.files) {
                Array.from(event.target.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-28 h-28 object-cover rounded-xl border-2 border-[#4285F4] p-1 shadow-md';
                        imagesPreviewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    });
</script>
@endpush
@endsection