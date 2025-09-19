@extends('admin.layout')

@section('title', 'إضافة إعلان جديد')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
    
    .google-form {
        font-family: 'Roboto', sans-serif;
    }
    
    .google-input {
        border: 1px solid #DADCE0;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.2s ease;
    }
    
    .google-input:focus {
        outline: none;
        border-color: #4285F4;
        box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
    }
    
    .google-select {
        background-color: #fff;
        border: 1px solid #DADCE0;
        border-radius: 12px;
        padding: 12px 16px;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234285F4' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: left 16px center;
        background-size: 16px;
        padding-left: 40px;
    }
    
    .google-btn {
        background-color: #4285F4;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 12px 24px;
        font-weight: 500;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(66, 133, 244, 0.3);
    }
    
    .google-btn:hover {
        background-color: #3367d6;
        box-shadow: 0 4px 12px rgba(66, 133, 244, 0.4);
        transform: translateY(-2px);
    }
    
    .google-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        padding: 24px;
        margin-bottom: 24px;
    }
    
    .google-section-title {
        color: #202124;
        font-size: 20px;
        font-weight: 500;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f1f3f4;
    }
    
    .google-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #5f6368;
    }
    
    .google-file-input {
        border: 2px dashed #DADCE0;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .google-file-input:hover {
        border-color: #4285F4;
        background-color: rgba(66, 133, 244, 0.03);
    }
    
    .google-tag-select {
        border: 1px solid #DADCE0;
        border-radius: 12px;
        padding: 8px;
    }
    
    .google-error {
        background-color: #fce8e6;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
        border-right: 4px solid #ea4335;
    }
    
    .google-error-title {
        font-weight: 500;
        color: #202124;
        margin-bottom: 8px;
    }
    
    .google-error-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    
    .google-error-list li {
        padding: 4px 0;
        color: #5f6368;
        position: relative;
        padding-left: 20px;
    }
    
    .google-error-list li:before {
        content: "•";
        color: #ea4335;
        position: absolute;
        left: 0;
        font-size: 20px;
        line-height: 1;
    }
    
    .color-accent-red { color: #EA4335; }
    .color-accent-blue { color: #4285F4; }
    .color-accent-green { color: #34A853; }
    .color-accent-yellow { color: #FBBC05; }
</style>

<div class="google-form max-w-4xl mx-auto p-4 md:p-6">
    <h1 class="text-2xl md:text-3xl font-bold mb-6 text-gray-800">إضافة إعلان جديد</h1>

    {{-- رسائل الأخطاء --}}
    @if ($errors->any())
    <div class="google-error">
        <div class="google-error-title">يرجى إصلاح الأخطاء التالية:</div>
        <ul class="google-error-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- القسم الأول: المعلومات الأساسية --}}
        <section class="google-section">
            <h2 class="google-section-title">المعلومات الأساسية</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- عنوان الإعلان --}}
                <div class="md:col-span-2">
                    <label for="title" class="google-label">عنوان الإعلان</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="google-input w-full" required>
                </div>

                {{-- السعر --}}
                <div>
                    <label for="price" class="google-label">السعر</label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" class="google-input w-full" required>
                </div>

                {{-- الحالة --}}
                <div>
                    <label for="status" class="google-label">الحالة</label>
                    <select name="status" id="status" class="google-select w-full">
                        <option value="pending" @selected(old('status') == 'pending')>معلق</option>
                        <option value="active" @selected(old('status') == 'active')>نشط</option>
                        <option value="inactive" @selected(old('status') == 'inactive')>غير نشط</option>
                        <option value="expired" @selected(old('status') == 'expired')>منتهي</option>
                    </select>
                </div>

                {{-- الوصف --}}
                <div class="md:col-span-2">
                    <label for="description" class="google-label">الوصف</label>
                    <textarea name="description" id="description" rows="5" class="google-input w-full">{{ old('description') }}</textarea>
                </div>
            </div>
        </section>

        {{-- القسم الثاني: مواصفات السيارة --}}
        <section class="google-section">
            <h2 class="google-section-title">مواصفات السيارة</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <div>
                        <label for="category_{{ $category->id }}" class="google-label">{{ $category->name }}</label>
                        @if($category->type === 'select')
                            <select name="categories[{{ $category->id }}]" id="category_{{ $category->id }}" class="google-select w-full">
                                <option value="">-- اختر --</option>
                                @foreach($category->categoryValues as $value)
                                    <option value="{{ $value->id }}" @selected(old('categories.' . $category->id) == $value->id)>{{ $value->value }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="{{ $category->type }}" name="categories[{{ $category->id }}]" id="category_{{ $category->id }}" value="{{ old('categories.' . $category->id) }}" class="google-input w-full">
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
        
        {{-- القسم الثالث: الصور والوسوم --}}
      <section class="google-section">
    <h2 class="google-section-title">الصور والوسوم</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- الصورة الرئيسية --}}
        <div>
            <label for="main_image" class="google-label">الصورة الرئيسية</label>
            <div class="relative">
                <label class="google-file-input cursor-pointer block">
                    <div class="flex flex-col items-center justify-center py-8">
                        <svg class="w-12 h-12 color-accent-blue mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-600 mb-1">انقر لتحميل الصورة</p>
                        <p class="text-sm text-gray-500">JPG, PNG أو GIF</p>
                    </div>
                    <input type="file" name="main_image" id="main_image" class="hidden" accept="image/*">
                </label>
                <div id="main_image_preview_container" class="mt-4 flex justify-center">
                    <img id="main_image_preview" class="w-40 h-40 object-cover hidden rounded-xl border-2 border-gray-200 p-1" />
                </div>
            </div>
        </div>

        {{-- الصور الإضافية --}}
        <div>
            <label for="images" class="google-label">صور إضافية (متعدد)</label>
            <div class="relative">
                <label class="google-file-input cursor-pointer block">
                    <div class="flex flex-col items-center justify-center py-8">
                        <svg class="w-12 h-12 color-accent-green mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="text-gray-600 mb-1">تحميل صور متعددة</p>
                        <p class="text-sm text-gray-500">اختر عدة صور دفعة واحدة</p>
                    </div>
                    <input type="file" name="images[]" id="images" multiple class="hidden" accept="image/*">
                </label>
                <div id="images_preview" class="flex flex-wrap gap-3 mt-4 justify-center min-h-[100px]"></div>
            </div>
        </div>

        
    </div>
</section>
        {{-- زر الحفظ --}}
        <div class="pt-4 flex justify-end">
            <button type="submit" class="google-btn flex items-center justify-center gap-2 px-6 py-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>حفظ الإعلان</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // سكريبت معاينة الصورة الرئيسية
        const mainImageInput = document.getElementById('main_image');
        const mainImagePreview = document.getElementById('main_image_preview');

        if (mainImageInput) {
            mainImageInput.addEventListener('change', function(event) {
                if (event.target.files && event.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        mainImagePreview.src = e.target.result;
                        mainImagePreview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(event.target.files[0]);
                }
            });
        }

        // سكريبت معاينة الصور الإضافية مع إمكانية الحذف
        const imagesInput = document.getElementById('images');
        const previewContainer = document.getElementById('images_preview');
        let filesArray = [];

        if (imagesInput && previewContainer) {
            imagesInput.addEventListener('change', function(e){
                const newFiles = Array.from(e.target.files);
                newFiles.forEach(file => {
                    if (!filesArray.some(f => f.name === file.name)) {
                        filesArray.push(file);
                    }
                });
                renderPreviews();
                updateInputFiles();
            });

            function renderPreviews() {
                previewContainer.innerHTML = '';
                filesArray.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e){
                        const wrapper = document.createElement('div');
                        wrapper.classList.add('relative', 'group', 'w-24', 'h-24');

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('w-full','h-full','object-cover','rounded-xl', 'border', 'p-1');

                        const removeBtn = document.createElement('button');
                        removeBtn.innerHTML = '&times;';
                        removeBtn.type = 'button';
                        removeBtn.classList.add('absolute','-top-2','-right-2','bg-red-500','text-white','rounded-full','w-6','h-6','flex','items-center','justify-center', 'text-lg', 'font-bold', 'opacity-0', 'group-hover:opacity-100', 'transition-opacity', 'cursor-pointer');
                        removeBtn.onclick = () => {
                            filesArray.splice(index, 1);
                            renderPreviews();
                            updateInputFiles();
                        };

                        wrapper.appendChild(img);
                        wrapper.appendChild(removeBtn);
                        previewContainer.appendChild(wrapper);
                    }
                    reader.readAsDataURL(file);
                });
            }

            function updateInputFiles(){
                const dataTransfer = new DataTransfer();
                filesArray.forEach(file => dataTransfer.items.add(file));
                imagesInput.files = dataTransfer.files;
            }
        }
    });
</script>
@endpush