@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Chi tiết Bác sĩ: {{ $doctor->user->name }}</h1>

<div class="bg-white shadow-md rounded-lg p-6 mb-4">
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">ID:</strong>
        <p class="text-gray-900">{{ $doctor->id }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Tên Bác sĩ:</strong>
        <p class="text-gray-900">{{ $doctor->user->name }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Email:</strong>
        <p class="text-gray-900">{{ $doctor->user->email }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Chuyên khoa:</strong>
        <p class="text-gray-900">{{ $doctor->specialty->name ?? 'Chưa xác định' }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Điện thoại:</strong>
        <p class="text-gray-900">{{ $doctor->phone ?? 'N/A' }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Địa chỉ:</strong>
        <p class="text-gray-900">{{ $doctor->address ?? 'N/A' }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Tiểu sử/Giới thiệu:</strong>
        <p class="text-gray-900">{{ $doctor->bio ?? 'N/A' }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Ngày tạo:</strong>
        <p class="text-gray-900">{{ $doctor->created_at->format('d/m/Y H:i:s') }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Cập nhật cuối:</strong>
        <p class="text-gray-900">{{ $doctor->updated_at->format('d/m/Y H:i:s') }}</p>
    </div>
</div>

<div class="flex space-x-2">
    <a href="{{ route('doctors.edit', $doctor->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Sửa</a>
    <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Bạn có chắc chắn muốn xóa bác sĩ này? Hành động này cũng sẽ xóa tài khoản người dùng liên quan.')">Xóa</button>
    </form>
    <a href="{{ route('doctors.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Quay lại</a>
</div>
@endsection