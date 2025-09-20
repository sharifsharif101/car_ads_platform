@extends('admin.layout')

@section('title', 'إدارة التصنيفات')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-semibold text-primary tracking-tight">إدارة التصنيفات</h1>
        <p class="mt-2 text-gray-600 max-w-2xl mx-auto">عرض وتعديل أو حذف التصنيفات المستخدمة في النظام</p>
    </div>

    @if(session('success'))
        <div 
            id="success-message" 
            class="mb-8 p-4 bg-green-50 text-green-700 border-l-4 border-green-500 rounded-lg shadow-sm animate-fadeIn opacity-100 transition-opacity duration-500"
        >
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const msg = document.getElementById('success-message');
                if (msg) {
                    msg.classList.add('opacity-0');
                    setTimeout(() => msg.remove(), 500);
                }
            }, 2000);
        </script>
    @endif

    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.categories.create') }}" 
           class="bg-accent hover:bg-accent-dark text-black px-5 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 inline-flex items-center">
            <span>إضافة تصنيف جديد</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-secondary text-black">
                    <tr>
                        <th class="py-3 px-4 text-right text-sm font-medium">#</th>
                        <th class="py-3 px-4 text-right text-sm font-medium">الاسم</th>
                        <th class="py-3 px-4 text-center text-sm font-medium">النوع</th>
                        <th class="py-3 px-4 text-center text-sm font-medium">عدد القيم</th>
                        <th class="py-3 px-4 text-center text-sm font-medium">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100 text-gray-700">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-3 px-4 text-sm font-medium">{{ $category->id }}</td>
                        <td class="py-3 px-4 text-sm font-medium">{{ $category->name }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="bg-indigo-100 text-indigo-700 py-1 px-3 rounded-full text-xs font-medium">
                                {{ $category->type }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center text-sm">
                            @if($category->type == 'select')
                                <span class="font-semibold">{{ $category->values->count() }}</span>
                            @else
                                <span class="text-gray-400 text-sm">لا يوجد</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-sm space-x-2 flex justify-center gap-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" 
                               class="bg-accent hover:bg-accent-dark text-black px-3 py-1.5 rounded shadow hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                                تعديل
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" 
                                  onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا التصنيف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-black px-3 py-1.5 rounded shadow hover:shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                                    حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 px-6 text-center text-gray-500">
                            لا توجد تصنيفات لعرضها.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        {{ $categories->links() }}
    </div>
</div>
@endsection