@extends('admin.layout')

@section('title', 'تعديل الوسم')

@section('content')
<h1 class="text-2xl font-bold mb-6 text-primary">تعديل الوسم: {{ $tag->name }}</h1>

@if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.tags.update', $tag->id) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-md">
    @csrf
    @method('PUT')

    <div>
        <label for="name" class="block mb-1 font-medium">اسم الوسم</label>
        <input type="text" name="name" id="name" value="{{ old('name', $tag->name) }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" required>
    </div>

    <div>
        <button type="submit" class="bg-accent text-white px-4 py-2 rounded hover:bg-accent/80">تحديث الوسم</button>
        <a href="{{ route('admin.tags.index') }}" class="text-gray-600 px-4 py-2 rounded hover:bg-gray-100">إلغاء</a>
    </div>
</form>
@endsection