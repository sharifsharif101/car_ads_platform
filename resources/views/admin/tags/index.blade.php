@extends('admin.layout')

@section('title', 'إدارة الوسوم')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-primary">إدارة الوسوم (Tags)</h1>
    <a href="{{ route('admin.tags.create') }}" class="bg-accent text-white px-4 py-2 rounded-lg hover:bg-accent/80">
        إضافة وسم جديد
    </a>
</div>

@if (session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white p-6 rounded-lg shadow-md">
    <table class="w-full text-right">
        <thead class="border-b-2 border-gray-200">
            <tr>
                <th class="p-3">#</th>
                <th class="p-3">الاسم</th>
                <th class="p-3">عدد الإعلانات المرتبطة</th>
                <th class="p-3">الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tags as $tag)
                <tr class="border-b border-gray-100">
                    <td class="p-3">{{ $tag->id }}</td>
                    <td class="p-3 font-medium">{{ $tag->name }}</td>
                    <td class="p-3">{{ $tag->cars_count }}</td>
                    <td class="p-3 flex items-center gap-2">
                        <a href="{{ route('admin.tags.edit', $tag->id) }}" class="text-blue-500 hover:text-blue-700">تعديل</a>
                        <span class="text-gray-300">|</span>
                        <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في الحذف؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-3 text-center text-gray-500">لا توجد وسوم لعرضها.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-6">
        {{ $tags->links() }}
    </div>
</div>
@endsection