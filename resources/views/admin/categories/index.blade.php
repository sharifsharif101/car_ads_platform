@extends('admin.layout')

@section('title', 'إدارة التصنيفات')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-primary">إدارة التصنيفات</h1>
    <a href="{{ route('admin.categories.create') }}" class="bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary-dark transition">
        إضافة تصنيف جديد
    </a>
</div>

@if(session('success'))
    <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-500" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                alert.classList.add('opacity-0'); // يخفّ تدريجيًا
                setTimeout(() => alert.remove(), 500); // إزالة العنصر بعد الاختفاء
            }, 3000); // 3 ثوانٍ قبل الاختفاء
        }
    });
    </script>
@endif


<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-right">#</th>
                    <th class="py-3 px-6 text-right">الاسم</th>
                    <th class="py-3 px-6 text-center">النوع</th>
                    <th class="py-3 px-6 text-center">القيم</th>
                    <th class="py-3 px-6 text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($categories as $category)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-right whitespace-nowrap">{{ $category->id }}</td>
                        <td class="py-3 px-6 text-right">{{ $category->name }}</td>
                        <td class="py-3 px-6 text-center">
                            <span class="bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs">{{ $category->type }}</span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            @if($category->type == 'select')
                                {{ $category->values->count() }}
                            @else
                                <span class="text-gray-400">لا يوجد</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mr-2 transform hover:scale-110">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا التصنيف؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-500 text-white flex items-center justify-center transform hover:scale-110">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-6 text-center text-gray-500">
                            لا توجد تصنيفات لعرضها.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>
@endsection