@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Quản lý Sinh viên') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('students.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Thêm Sinh viên</a>
        <!-- Button nhập danh sách sinh viên từ Excel -->
        <a href="{{ route('students.import') }}" class="px-4 py-2 bg-green-500 text-white rounded">
            Import Sinh viên
        </a>
    </div>
    <div class="bg-white shadow-sm sm:rounded-lg p-6">
      <table class="w-full divide-y-2 divide-gray-700">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 text-left">ID</th>
            <th class="px-4 py-2 text-left">Tên</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Số điện thoại</th>
            <th class="px-4 py-2 text-left">Ngày sinh</th>
            <th class="px-4 py-2 text-left">Hành động</th>
          </tr>
        </thead>
        <tbody class="divide-y-2 divide-gray-700">
          @foreach($students as $student)
          <tr>
            <td class="px-4 py-2">{{ $student->id }}</td>
            <td class="px-4 py-2">{{ $student->name }}</td>
            <td class="px-4 py-2">{{ $student->email }}</td>
            <td class="px-4 py-2">{{ $student->phone }}</td>
            <td class="px-4 py-2">{{ $student->birth_date }}</td>
            <td class="px-4 py-2">
              <a href="{{ route('students.edit', $student->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded inline-block mr-2">
                Chỉnh sửa
              </a>
              <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded" onclick="return confirm('Bạn có chắc không?')">
                  Xóa
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
