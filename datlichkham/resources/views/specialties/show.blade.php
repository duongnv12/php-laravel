@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Chi tiết Chuyên khoa: {{ $specialty->name }}</h1>

<div class="bg-white shadow-md rounded-lg p-6 mb-4">
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">ID:</strong>
        <p class="text-gray-900">{{ $specialty->id }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Tên Chuyên khoa:</strong>
        <p class="text-gray-900">{{ $specialty->name }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Mô tả:</strong>
        <p class="text-gray-900">{{ $specialty->description ?? 'N/A' }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Ngày tạo:</strong>
        <p class="text-gray-900">{{ $specialty->created_at->format('d/m/Y H:i:s') }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Cập nhật cuối:</strong>
        <p class="text-gray-900">{{ $specialty->updated_at->format('d/m/Y H:i:s') }}</p>
    </div>
</div>

<div class="flex space-x-2">
    <a href="{{ route('specialties.edit', $specialty->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Sửa</a>
    <form action="{{ route('specialties.destroy', $specialty->id) }}" method="POST" class="inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Bạn có chắc chắn muốn xóa chuyên khoa này?')">Xóa</button>
    </form>
    <a href="{{ route('specialties.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Quay lại</a>
</div>
@endsection