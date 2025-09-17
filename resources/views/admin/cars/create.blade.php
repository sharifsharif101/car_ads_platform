@extends('admin.layout')

@section('title', 'إضافة إعلان جديد')

@section('content')
<h1 class="text-2xl font-bold mb-6 text-primary">إضافة إعلان جديد</h1>

@if ($errors->any())
<div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
    <strong class="font-bold">حدث خطأ!</strong>
    <ul>
        @foreach ($errors->all() as $error)
            <li>- {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
    @csrf

    {{-- الحقول الأساسية للإعلان --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="title" class="block mb-1 font-medium">عنوان الإعلان</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" required>
        </div>

        <div>
            <label for="price" class="block mb-1 font-medium">السعر</label>
            <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" required>
        </div>

        <div>
            <label for="status" class="block mb-1 font-medium">الحالة</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="pending" @selected(old('status') == 'pending')>معلق</option>
                <option value="active" @selected(old('status') == 'active')>نشط</option>
                <option value="inactive" @selected(old('status') == 'inactive')>غير نشط</option>
                <option value="expired" @selected(old('status') == 'expired')>منتهي</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <label for="description" class="block mb-1 font-medium">الوصف</label>
            <textarea name="description" id="description" rows="4" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">{{ old('description') }}</textarea>
        </div>
    </div>

    <hr>

    {{-- قسم التصنيفات الديناميكي --}}
    <h2 class="text-xl font-semibold text-gray-700">مواصفات السيارة</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- سيتم تكرار هذا الجزء لكل تصنيف ترسله من الكنترولر --}}
        @foreach ($categories as $category)
            <div>
                <label for="category_{{ $category->id }}" class="block mb-1 font-medium">{{ $category->name }}</label>
                
                @if($category->type === 'select')
                    <select name="categories[{{ $category->id }}]" id="category_{{ $category->id }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">-- اختر {{ $category->name }} --</option>
                        @foreach($category->categoryValues as $value)
                            <option value="{{ $value->id }}" @selected(old('categories.' . $category->id) == $value->id)>
                                {{ $value->value }}
                            </option>
                        @endforeach
                    </select>

                @elseif($category->type === 'text')
                    <input type="text" name="categories[{{ $category->id }}]" id="category_{{ $category->id }}" value="{{ old('categories.' . $category->id) }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                
                @elseif($category->type === 'number')
                    <input type="number" name="categories[{{ $category->id }}]" id="category_{{ $category->id }}" value="{{ old('categories.' . $category->id) }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                @endif
            </div>
        @endforeach
    </div>

    <hr>
    
    {{-- قسم الصور والوسوم --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block mb-1 font-medium">الصورة الرئيسية</label>
            <input type="file" name="main_image" id="main_image" class="w-full border rounded px-3 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
            <img id="main_image_preview" class="mt-2 w-32 h-32 object-cover hidden rounded-lg border p-1" />
        </div>

        <div>
            <label class="block mb-1 font-medium">صور إضافية</label>
            <input type="file" name="images[]" id="images" multiple class="w-full border rounded px-3 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
            <div id="images_preview" class="flex flex-wrap gap-2 mt-2"></div>
        </div>

        <div class="md:col-span-2">
            <label for="tags" class="block mb-1 font-medium">الوسوم (Tags)</label>
            <select id="tags" name="tags[]" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="pt-4">
        <button type="submit" class="bg-accent text-white px-6 py-2 rounded-lg font-semibold hover:bg-accent/80 transition-colors">حفظ الإعلان</button>
    </div>
</form>
@endsection

@push('scripts')
{{-- تأكد من أنك تستخدم مكتبة TomSelect --}}
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
    // تفعيل TomSelect للوسوم
    new TomSelect("#tags",{
        create: true,
        sortField: {field: "text", direction: "asc"}
    });

    // سكريبت معاينة الصورة الرئيسية
    const mainImageInput = document.getElementById('main_image');
    const mainImagePreview = document.getElementById('main_image_preview');

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

    // سكريبت معاينة الصور الإضافية مع إمكانية الحذف
    const imagesInput = document.getElementById('images');
    const previewContainer = document.getElementById('images_preview');
    let filesArray = [];

    imagesInput.addEventListener('change', function(e){
        const files = Array.from(e.target.files);

        files.forEach(file => {
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
                wrapper.classList.add('relative', 'group');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('w-24','h-24','object-cover','rounded-lg', 'border', 'p-1');

                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '&times;';
                removeBtn.type = 'button';
                removeBtn.classList.add('absolute','-top-2','-right-2','bg-red-500','text-white','rounded-full','w-6','h-6','flex','items-center','justify-center', 'text-lg', 'font-bold', 'opacity-0', 'group-hover:opacity-100', 'transition-opacity');
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
</script>
 
@endpush