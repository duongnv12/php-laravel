@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Danh sách Khóa học') }}
    </h2>
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <div class="mb-4">
            <a href="{{ route('courses.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Thêm Khóa học mới</a>
        </div>
        @if($courses->count())
            <div class="overflow-x-auto">
                <table class="min-w-full table-fixed bg-white border-collapse">
                    <thead>
                        <tr>
                            <!-- Cột ID được giới hạn bằng lớp w-1/12 -->
                            <th class="py-2 px-4 border-b text-left w-1/12">ID</th>
                            <th class="py-2 px-4 border-b text-left w-2/12">Tiêu đề</th>
                            <th class="py-2 px-4 border-b text-left w-2/12">Mô tả</th>
                            <th class="py-2 px-4 border-b text-left w-2/12">Ngày bắt đầu</th>
                            <th class="py-2 px-4 border-b text-left w-2/12">Ngày kết thúc</th>
                            <th class="py-2 px-4 border-b text-left w-2/12">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b">{{ $course->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $course->title }}</td>
                                <td class="py-2 px-4 border-b">{{ Str::limit($course->description, 50) }}</td>
                                <td class="py-2 px-4 border-b">
                                    {{ $course->start_date ? $course->start_date->format('d/m/Y') : '' }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    {{ $course->end_date ? $course->end_date->format('d/m/Y') : '' }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('courses.show', $course->id) }}" class="text-blue-600 hover:underline">Xem</a>
                                    <a href="{{ route('courses.edit', $course->id) }}"
                                        class="text-yellow-600 hover:underline ml-2">Sửa</a>
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                        class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa khóa học này?')"
                                            class="text-red-600 hover:underline">
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
            <p>Không có dữ liệu khóa học nào.</p>
        @endif
    </div>
@endsection