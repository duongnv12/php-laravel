@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Danh sách Sinh viên') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('students.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Thêm Sinh viên</a>
        <!-- Button nhập danh sách sinh viên từ Excel -->
        <a href="{{ route('students.import') }}" class="px-4 py-2 bg-green-500 text-white rounded">
            Import Sinh viên
        </a>
    </div>
    @if($students->count())
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white border-collapse">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left w-1/12">ID</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Tên</th>
                        <th class="py-2 px-4 border-b text-left w-3/12">Email</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">SĐT</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Ngày sinh</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $student->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $student->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $student->email }}</td>
                        <td class="py-2 px-4 border-b">{{ $student->phone }}</td>
                        <td class="py-2 px-4 border-b">
                            {{ $student->dob ? $student->dob->format('d/m/Y') : '' }}
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 hover:underline">Xem</a>
                            <a href="{{ route('students.edit', $student->id) }}" class="text-yellow-600 hover:underline ml-2">Sửa</a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')" class="text-red-600 hover:underline">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Không có dữ liệu sinh viên nào.</p>
    @endif
</div>
@endsection
