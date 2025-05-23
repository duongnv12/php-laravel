@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Danh sách Chuyên khoa</h1>
<a href="{{ route('specialties.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Thêm Chuyên khoa mới</a>

<div class="bg-white shadow-md rounded-lg p-4">
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b text-left">Tên Chuyên khoa</th>
                <th class="py-2 px-4 border-b text-left">Mô tả</th>
                <th class="py-2 px-4 border-b">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($specialties as $specialty)
            <tr>
                <td class="py-2 px-4 border-b text-center">{{ $specialty->id }}</td>
                <td class="py-2 px-4 border-b">{{ $specialty->name }}</td>
                <td class="py-2 px-4 border-b">{{ $specialty->description }}</td>
                <td class="py-2 px-4 border-b text-center">
                    <a href="{{ route('specialties.show', $specialty->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Xem</a>
                    <a href="{{ route('specialties.edit', $specialty->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Sửa</a>
                    <form action="{{ route('specialties.destroy', $specialty->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bạn có chắc chắn muốn xóa chuyên khoa này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-4 px-4 text-center text-gray-500">Không có chuyên khoa nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection