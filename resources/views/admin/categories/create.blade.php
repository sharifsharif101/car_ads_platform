@extends('admin.layout')

@section('title', 'إضافة تصنيف جديد')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-semibold text-primary tracking-tight">إضافة تصنيف جديد</h1>
        <p class="mt-2 text-gray-600 max-w-xl mx-auto">قم بإضافة تصنيف جديد مع تحديد نوعه وقيمته إن لزم الأمر</p>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 p-6">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <!-- اسم التصنيف -->
            <div class="mb-6">
                <label for="name" class="block text-gray-700 text-sm font-medium mb-2">اسم التصنيف</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-accent focus:border-accent @error('name') border-red-500 @enderror"
                    required
                >
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- تم حذف حقل اختيار النوع -->

            <!-- حاوية قيم التصنيف (تظهر عند اختيار select) -->
            <div id="values-container" class="mb-6 border border-gray-200 p-4 rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-800">قيم التصنيف</h3>
                    <button type="button" id="add-value-btn" class="bg-accent hover:bg-accent-dark text-black px-3 py-1.5 rounded shadow hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5 text-sm">
                        إضافة قيمة
                    </button>
                </div>
                <div id="values-inputs">
                    @if(old('values'))
                        @foreach(old('values') as $value)
                            <div class="flex items-center mb-2 value-input-group">
                                <input 
                                    type="text" 
                                    name="values[]" 
                                    value="{{ $value }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-accent focus:border-accent mr-2" 
                                    placeholder="أدخل القيمة"
                                >
                                <button type="button" class="remove-value-btn bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center transition">
                                    &times;
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                @error('values.*')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- زر الحفظ -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-800 transition">
                    &larr; العودة إلى القائمة
                </a>
                <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-medium py-2.5 px-6 rounded-lg shadow hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                    حفظ التصنيف
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addValueBtn = document.getElementById('add-value-btn');
    const valuesInputs = document.getElementById('values-inputs');

    // إضافة حقل إدخال جديد
    addValueBtn.addEventListener('click', function () {
        const inputGroup = document.createElement('div');
        inputGroup.className = 'flex items-center mb-2 value-input-group';
        inputGroup.innerHTML = `
            <input 
                type="text" 
                name="values[]" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-accent focus:border-accent mr-2" 
                placeholder="أدخل القيمة" 
                required
            >
            <button type="button" class="remove-value-btn bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center transition">
                &times;
            </button>
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