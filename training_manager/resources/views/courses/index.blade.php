@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Quản lý Môn học') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('courses.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
            Thêm Môn học
        </a>
        <!-- Nếu có chức năng import, bạn có thể thêm button nhập từ Excel -->
        <a href="{{ route('courses.import') }}" class="px-4 py-2 bg-green-500 text-white rounded">
            Import Môn học
        </a>
    </div>
    <div class="bg-white shadow-sm sm:rounded-lg p-6">
      <table class="w-full divide-y-2 divide-gray-700">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 text-left">ID</th>
            <th class="px-4 py-2 text-left">Mã môn</th>
            <th class="px-4 py-2 text-left">Tên môn</th>
            <th class="px-4 py-2 text-left">Mô tả</th>
            <th class="px-4 py-2 text-left">Hành động</th>
          </tr>
        </thead>
        <tbody class="divide-y-2 divide-gray-700">
          @foreach($courses as $course)
          <tr>
            <td class="px-4 py-2">{{ $course->id }}</td>
            <td class="px-4 py-2">{{ $course->code }}</td>
            <td class="px-4 py-2">{{ $course->name }}</td>
            <td class="px-4 py-2">{{ $course->description }}</td>
            <td class="px-4 py-2">
              <a href="{{ route('courses.edit', $course->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded inline-block mr-2">
                Chỉnh sửa
              </a>
              <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="inline-block">
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
