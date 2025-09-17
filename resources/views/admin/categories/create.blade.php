@extends('admin.layout')

@section('title', 'إضافة تصنيف جديد')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-primary">إضافة تصنيف جديد</h1>
    <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 transition">
        العودة إلى القائمة
    </a>
</div>

<div class="bg-white p-8 rounded-lg shadow-md">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <!-- اسم التصنيف -->
        <div class="mb-6">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">اسم التصنيف:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" required>
            @error('name')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- نوع التصنيف -->
        <div class="mb-6">
            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">نوع الحقل:</label>
            <select id="type" name="type" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('type') border-red-500 @enderror" required>
                <option value="select" {{ old('type') == 'select' ? 'selected' : '' }}>Select (قائمة منسدلة)</option>
                <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text (حقل نصي)</option>
                <option value="number" {{ old('type') == 'number' ? 'selected' : '' }}>Number (حقل رقمي)</option>
            </select>
            @error('type')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- حاوية قيم التصنيف (تظهر عند اختيار select) -->
        <div id="values-container" class="mb-6 border p-4 rounded-md {{ old('type', 'select') == 'select' ? '' : 'hidden' }}">
            <div class="flex justify-between items-center mb-4">
                 <h3 class="text-lg font-semibold">قيم التصنيف</h3>
                 <button type="button" id="add-value-btn" class="bg-blue-500 text-white py-1 px-3 rounded-lg hover:bg-blue-600 text-sm">إضافة قيمة</button>
            </div>
            <div id="values-inputs">
                <!-- حقول القيم ستضاف هنا ديناميكياً -->
                @if(old('values'))
                    @foreach(old('values') as $value)
                        <div class="flex items-center mb-2 value-input-group">
                            <input type="text" name="values[]" value="{{ $value }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mr-2 leading-tight focus:outline-none focus:shadow-outline" placeholder="أدخل القيمة">
                            <button type="button" class="remove-value-btn bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center">&times;</button>
                        </div>
                    @endforeach
                @endif
            </div>
             @error('values.*')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>


        <!-- زر الحفظ -->
        <div class="flex items-center justify-start">
            <button type="submit" class="bg-primary text-white font-bold py-2 px-6 rounded-lg hover:bg-primary-dark focus:outline-none focus:shadow-outline transition">
                حفظ التصنيف
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const valuesContainer = document.getElementById('values-container');
    const addValueBtn = document.getElementById('add-value-btn');
    const valuesInputs = document.getElementById('values-inputs');

    // إظهار/إخفاء حقل القيم بناءً على نوع التصنيف
    typeSelect.addEventListener('change', function () {
        if (this.value === 'select') {
            valuesContainer.classList.remove('hidden');
        } else {
            valuesContainer.classList.add('hidden');
        }
    });

    // إضافة حقل إدخال جديد
    addValueBtn.addEventListener('click', function () {
        const inputGroup = document.createElement('div');
        inputGroup.className = 'flex items-center mb-2 value-input-group';
        inputGroup.innerHTML = `
            <input type="text" name="values[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mr-2 leading-tight focus:outline-none focus:shadow-outline" placeholder="أدخل القيمة" required>
            <button type="button" class="remove-value-btn bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center">&times;</button>
        `;
        valuesInputs.appendChild(inputGroup);
    });

    // حذف حقل إدخال
    valuesInputs.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-value-btn')) {
            e.target.closest('.value-input-group').remove();
        }
    });
});
</script>
@endpush
@endsection