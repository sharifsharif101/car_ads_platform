@extends('admin.layout')

@section('title', 'إدارة الإعلانات')

@section('content')
<h1 class="text-2xl font-bold mb-6 text-primary">إدارة الإعلانات</h1>

<a href="{{ route('admin.cars.create') }}" class="bg-accent text-white px-4 py-2 rounded hover:bg-accent/80 mb-4 inline-block">إضافة إعلان جديد</a>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-lg shadow">
        <thead class="bg-secondary text-white">
            <tr>
                <th class="py-2 px-4">#</th>
                <th class="py-2 px-4">عنوان الإعلان</th>
                <th class="py-2 px-4">السعر</th>
                <th class="py-2 px-4">الحالة</th>
                <th class="py-2 px-4">إجراءات</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            @foreach($cars as $car)
            <tr class="border-b hover:bg-lightbg/50">
                <td class="py-2 px-4">{{ $car->id }}</td>
                <td class="py-2 px-4">{{ $car->title }}</td>
                <td class="py-2 px-4">{{ $car->price }} ريال</td>
                <td class="py-2 px-4">{{ $car->status }}</td>
                <td class="py-2 px-4 flex gap-2">
                    <a href="{{ route('admin.cars.edit', $car) }}" class="bg-accent text-white px-3 py-1 rounded hover:bg-accent/80">تعديل</a>
                    <form action="{{ route('admin.cars.destroy', $car) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $cars->links() }}
</div>
@endsection
