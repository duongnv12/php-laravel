@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Danh sách Bác sĩ</h1>
<a href="{{ route('doctors.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Thêm Bác sĩ mới</a>

<div class="bg-white shadow-md rounded-lg p-4">
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b text-left">Tên Bác sĩ</th>
                <th class="py-2 px-4 border-b text-left">Email</th>
                <th class="py-2 px-4 border-b text-left">Chuyên khoa</th>
                <th class="py-2 px-4 border-b text-left">Điện thoại</th>
                <th class="py-2 px-4 border-b">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($doctors as $doctor)
            <tr>
                <td class="py-2 px-4 border-b text-center">{{ $doctor->id }}</td>
                <td class="py-2 px-4 border-b">{{ $doctor->user->name }}</td>
                <td class="py-2 px-4 border-b">{{ $doctor->user->email }}</td>
                <td class="py-2 px-4 border-b">{{ $doctor->specialty->name ?? 'Chưa xác định' }}</td>
                <td class="py-2 px-4 border-b">{{ $doctor->phone ?? 'N/A' }}</td>
                <td class="py-2 px-4 border-b text-center">
                    <a href="{{ route('doctors.show', $doctor->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Xem</a>
                    <a href="{{ route('doctors.edit', $doctor->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Sửa</a>
                    <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bạn có chắc chắn muốn xóa bác sĩ này? Hành động này cũng sẽ xóa tài khoản người dùng liên quan.')">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-4 px-4 text-center text-gray-500">Không có bác sĩ nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection