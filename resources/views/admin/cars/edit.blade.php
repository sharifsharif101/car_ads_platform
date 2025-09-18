@extends('admin.layout')
@section('title', 'تعديل الإعلان: ' . $car->title)
@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-primary">تعديل الإعلان: <span class="font-normal">{{ $car->title }}</span></h1>
        <a href="{{ route('admin.cars.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
            <i class="fa fa-arrow-left ml-2"></i>
            العودة إلى القائمة
        </a>
    </div>
code
Code
{{-- عرض أخطاء التحقق من المدخلات --}}
@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p class="font-bold">حدث خطأ!</p>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.cars.update', $car) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg space-y-8">
    @csrf
    @method('PUT')

    {{-- القسم الرئيسي للمعلومات --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- عنوان الإعلان --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">عنوان الإعلان <span class="text-red-500">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title', $car->title) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-accent focus:ring focus:ring-accent/50" required>
        </div>

        {{-- السعر --}}
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">السعر (ريال) <span class="text-red-500">*</span></label>
            <input type="number" id="price" name="price" value="{{ old('price', $car->price) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-accent focus:ring focus:ring-accent/50" required>
        </div>

        {{-- الحالة --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">الحالة <span class="text-red-500">*</span></label>
            <select id="status" name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-accent focus:ring focus:ring-accent/50">
                <option value="active" @selected(old('status', $car->status) == 'active')>نشط</option>
                <option value="inactive" @selected(old('status', $car->status) == 'inactive')>غير نشط</option>
                <option value="pending" @selected(old('status', $car->status) == 'pending')>قيد المراجعة</option>
                <option value="expired" @selected(old('status', $car->status) == 'expired')>منتهي</option>
            </select>
        </div>
        
        {{-- الوسوم (Tags) --}}
        <div>
            <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">الوسوم (Tags)</label>
            <select id="tags" name="tags[]" multiple>
                {{-- يتم ملء الوسوم المحفوظة مسبقًا عبر السكربت في الأسفل --}}
                @foreach($tags as $tag)
                    <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- الوصف --}}
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">الوصف</label>
        <textarea id="description" name="description" rows="5" class="w-full border-gray-300 rounded-md shadow-sm focus:border-accent focus:ring focus:ring-accent/50">{{ old('description', $car->description) }}</textarea>
    </div>

    <hr>

    {{-- قسم التصنيفات --}}
    <div>
        <h2 class="text-xl font-semibold mb-4 text-primary">التصنيفات</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <div>
                    <label for="category_{{ $category->id }}" class="block text-sm font-medium text-gray-700 mb-2">{{ $category->name }}</label>
                    <select name="categories[{{ $category->id }}]" id="category_{{ $category->id }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-accent focus:ring focus:ring-accent/50">
                        <option value="" class="text-black">-- اختر --</option style="color:black;">
                    
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

    <hr>

    {{-- قسم الصور --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- الصورة الأساسية --}}
        <div>
            <h3 class="text-lg font-semibold mb-2 text-primary">الصورة الأساسية</h3>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">الصورة الحالية</label>
                @if($car->main_image)
                    <img src="{{ Storage::url($car->main_image) }}" alt="الصورة الأساسية" class="w-32 h-32 object-cover rounded-md shadow-sm border">
                @else
                    <p class="text-gray-500">لا توجد صورة أساسية.</p>
                @endif
            </div>
            <div>
                <label for="main_image" class="block text-sm font-medium text-gray-700 mb-2">تغيير الصورة الأساسية (اختياري)</label>
                <input type="file" id="main_image" name="main_image" class="w-full border p-2 rounded-md file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-accent/80">
            </div>
        </div>

        {{-- الصور الإضافية --}}
        <div>
            <h3 class="text-lg font-semibold mb-2 text-primary">الصور الإضافية</h3>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">الصور الحالية</label>
                @if($car->images->isNotEmpty())
                    <div class="flex flex-wrap gap-4">
                        @foreach($car->images as $image)
                            <div class="relative group">
                                <img src="{{ Storage::url($image->image_path) }}" alt="صورة إضافية" class="w-24 h-24 object-cover rounded-md shadow-sm border">
                                <button type="submit" form="delete-image-{{ $image->id }}" onclick="return confirm('هل أنت متأكد من رغبتك في حذف هذه الصورة؟');" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold opacity-0 group-hover:opacity-100 transition-opacity">&times;</button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">لا توجد صور إضافية.</p>
                @endif
            </div>
             <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">إضافة صور جديدة (اختياري)</label>
                <input type="file" id="images" name="images[]" multiple class="w-full border p-2 rounded-md file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-accent/80">
                <div id="images_preview" class="flex flex-wrap gap-4 mt-4"></div>
            </div>
        </div>
    </div>

    {{-- زر التحديث --}}
    <div class="mt-8 pt-6 border-t flex justify-end">
        <button type="submit" class="bg-accent text-white px-8 py-3 rounded-md hover:bg-accent/80 transition-colors font-semibold">
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
                        img.className = 'w-24 h-24 object-cover rounded-lg border p-1';
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