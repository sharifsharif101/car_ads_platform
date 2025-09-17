@extends('admin.layout')

@section('title', 'إضافة إعلان جديد')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
    <h1 class="text-2xl md:text-3xl font-bold mb-6 text-primary border-b pb-4">إضافة إعلان جديد</h1>

    {{-- رسائل الأخطاء --}}
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-100 text-red-800 border-r-4 border-red-500 rounded-lg" role="alert">
        <strong class="font-bold block">يرجى إصلاح الأخطاء التالية:</strong>
        <ul class="list-disc list-inside mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        {{-- القسم الأول: المعلومات الأساسية --}}
        <section class="border p-5 rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">المعلومات الأساسية</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- عنوان الإعلان --}}
                <div class="md:col-span-2">
                    <label for="title" class="block mb-2 font-medium text-gray-600">عنوان الإعلان</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary transition" required>
                </div>

                {{-- السعر --}}
                <div>
                    <label for="price" class="block mb-2 font-medium text-gray-600">السعر</label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary transition" required>
                </div>

                {{-- الحالة --}}
                <div>
                    <label for="status" class="block mb-2 font-medium text-gray-600">الحالة</label>
                    <select name="status" id="status" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary transition">
                        <option value="pending" @selected(old('status') == 'pending')>معلق</option>
                        <option value="active" @selected(old('status') == 'active')>نشط</option>
                        <option value="inactive" @selected(old('status') == 'inactive')>غير نشط</option>
                        <option value="expired" @selected(old('status') == 'expired')>منتهي</option>
                    </select>
                </div>

                {{-- الوصف --}}
                <div class="md:col-span-2">
                    <label for="description" class="block mb-2 font-medium text-gray-600">الوصف</label>
                    <textarea name="description" id="description" rows="5" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary transition">{{ old('description') }}</textarea>
                </div>
            </div>
        </section>

        {{-- القسم الثاني: مواصفات السيارة --}}
        <section class="border p-5 rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">مواصفات السيارة</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <div>
                        <label for="category_{{ $category->id }}" class="block mb-2 font-medium text-gray-600">{{ $category->name }}</label>
                        @if($category->type === 'select')
                            <select name="categories[{{ $category->id }}]" id="category_{{ $category->id }}" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary transition">
                                <option value="">-- اختر --</option>
                                @foreach($category->categoryValues as $value)
                                    <option value="{{ $value->id }}" @selected(old('categories.' . $category->id) == $value->id)>{{ $value->value }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="{{ $category->type }}" name="categories[{{ $category->id }}]" id="category_{{ $category->id }}" value="{{ old('categories.' . $category->id) }}" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary transition">
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
        
        {{-- القسم الثالث: الصور والوسوم --}}
        <section class="border p-5 rounded-lg">
             <h2 class="text-xl font-semibold text-gray-700 mb-4">الصور والوسوم</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- الصورة الرئيسية --}}
                <div>
                    <label for="main_image" class="block mb-2 font-medium text-gray-600">الصورة الرئيسية</label>
                    <input type="file" name="main_image" id="main_image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                    <img id="main_image_preview" class="mt-4 w-40 h-40 object-cover hidden rounded-lg border-2 border-gray-200 p-1" />
                </div>

                {{-- الصور الإضافية --}}
                <div>
                    <label for="images" class="block mb-2 font-medium text-gray-600">صور إضافية (متعدد)</label>
                    <input type="file" name="images[]" id="images" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                    <div id="images_preview" class="flex flex-wrap gap-3 mt-4"></div>
                </div>

                {{-- الوسوم --}}
                <div class="lg:col-span-2">
                    <label for="tags" class="block mb-2 font-medium text-gray-600">الوسوم (Tags)</label>
                    <select id="tags" name="tags[]" multiple>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </section>

        {{-- زر الحفظ --}}
        <div class="pt-4 flex justify-end">
            <button type="submit" class="w-full sm:w-auto bg-accent text-white px-8 py-3 rounded-lg font-semibold hover:bg-accent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent transition-all duration-300 flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                <span>حفظ الإعلان</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // تفعيل TomSelect للوسوم
        if (document.getElementById('tags')) {
            new TomSelect("#tags",{
                create: true,
                sortField: {field: "text", direction: "asc"}
            });
        }

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
                        img.classList.add('w-full','h-full','object-cover','rounded-lg', 'border', 'p-1');

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