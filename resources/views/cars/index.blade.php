@extends('admin.layout')

@section('title', 'إعلانات السيارات')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-primary">إعلانات السيارات</h1>

    {{-- Filters/Search --}}
    <form method="GET" action="{{ route('cars.front.index') }}" class="bg-white p-4 rounded-lg shadow mb-6 grid grid-cols-1 md:grid-cols-6 gap-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="ابحث عن عنوان أو وصف" class="border rounded p-2 col-span-2"/>
        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="أقل سعر" class="border rounded p-2"/>
        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="أعلى سعر" class="border rounded p-2"/>

        <select name="tag" class="border rounded p-2">
            <option value="">كل الوسوم</option>
            @foreach($tags as $tag)
                <option value="{{ $tag->name }}" @selected(request('tag')===$tag->name)>{{ $tag->name }}</option>
            @endforeach
        </select>

        <select name="category_id" id="category_id" class="border rounded p-2">
            <option value="">كل التصنيفات</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id')==$category->id)>{{ $category->name }}</option>
            @endforeach
        </select>

        <select name="value_id" id="value_id" class="border rounded p-2">
            <option value="">كل القيم</option>
            {{-- سيتم ملء هذه القائمة بواسطة JavaScript، لكننا نحافظ على الكود أدناه ليعمل عند إعادة تحميل الصفحة بعد التصفية --}}
            @if(request('category_id'))
                @php $selectedCategory = $categories->firstWhere('id', (int)request('category_id')); @endphp
                @if($selectedCategory)
                    @foreach($selectedCategory->values as $value)
                        <option value="{{ $value->id }}" @selected(request('value_id')==$value->id)>{{ $value->value }}</option>
                    @endforeach
                @endif
            @endif
        </select>

        <button class="bg-accent text-white px-4 py-2 rounded hover:bg-accent/80">تصفية</button>
    </form>

    {{-- Cards grid --}}
{{-- in resources/views/cars/index.blade.php --}}

{{-- Cards grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($cars as $car)
        {{-- =================================================================== --}}
        {{-- البداية: هذا هو الرابط الذي يغلف البطاقة بأكملها --}}
        {{-- =================================================================== --}}
        <a href="{{ route('cars.front.show', $car) }}" class="block bg-white rounded-lg shadow overflow-hidden flex flex-col hover:shadow-xl transition-shadow duration-300">
            
            {{-- الجزء الأول داخل الرابط: حاوية الصورة --}}
            {{-- عند الضغط هنا، سيتم تفعيل الرابط --}}
            <div class="h-44 bg-gray-100">
                @if($car->main_image)
                    <img src="{{ Storage::url($car->main_image) }}" alt="{{ $car->title }}" class="w-full h-44 object-cover"/>
                @elseif($car->images->first())
                    <img src="{{ Storage::url($car->images->first()->image_path) }}" alt="{{ $car->title }}" class="w-full h-44 object-cover"/>
                @else
                    <div class="w-full h-44 flex items-center justify-center text-gray-400">لا توجد صورة</div>
                @endif
            </div>

            {{-- الجزء الثاني داخل الرابط: حاوية التفاصيل --}}
            {{-- عند الضغط هنا أيضاً، سيتم تفعيل نفس الرابط --}}
            <div class="p-4 flex-1 flex flex-col">
                <h3 class="text-lg font-semibold text-primary mb-1">{{ $car->title }}</h3>
                <p class="text-sm text-gray-600 line-clamp-3 mb-3">{{ Str::limit($car->description, 120) }}</p>
                <div class="text-accent font-bold mb-3">{{ number_format($car->price, 0) }} ريال</div>

                {{-- الوسوم --}}
                @if($car->tags->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach($car->tags as $tag)
                            <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">#{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif

                {{-- التصنيفات --}}
                @if($car->categoryValues->isNotEmpty())
                    <div class="text-xs text-gray-500 mt-auto">
                        @foreach($car->categoryValues as $val)
                            <span class="inline-block mr-1 bg-lightbg px-2 py-1 rounded">
                                {{ $val->category?->name }}: {{ $val->value }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        
        </a> {{-- نهاية وسم الرابط الذي يغلف كل شيء --}}
        {{-- =================================================================== --}}

    @empty
        <div class="col-span-full text-center text-gray-500">لا توجد نتائج مطابقة.</div>
    @endforelse
</div>

    <div class="mt-6">{{ $cars->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. استلام البيانات من PHP
    const categories = @json($categories->keyBy('id'));
    const categorySelect = document.getElementById('category_id');
    const valueSelect = document.getElementById('value_id');
    const selectedValueId = "{{ request('value_id') }}";

    function updateValueOptions() {
        const categoryId = categorySelect.value;
        const selectedCategory = categories[categoryId];

        // 2. إفراغ القائمة الحالية
        valueSelect.innerHTML = '<option value="">كل القيم</option>';

        if (selectedCategory && selectedCategory.values) {
            // 3. إضافة القيم الجديدة بناءً على التصنيف المختار
            selectedCategory.values.forEach(function (value) {
                const option = document.createElement('option');
                option.value = value.id;
                option.textContent = value.value;

                // إعادة تحديد القيمة السابقة إذا كانت موجودة
                if (value.id == selectedValueId) {
                    option.selected = true;
                }

                valueSelect.appendChild(option);
            });
        }
    }

    // 4. ربط الحدث عند تغيير التصنيف
    categorySelect.addEventListener('change', updateValueOptions);

    // 5. استدعاء الدالة عند تحميل الصفحة للتأكد من أن القائمة تظهر بشكل صحيح إذا كان هناك تصنيف محدد مسبقاً
    // هذا ليس ضرورياً بسبب الكود الموجود في PHP ولكن من الجيد وجوده
    if (categorySelect.value) {
        updateValueOptions();
    }
});
</script>
@endpush

 