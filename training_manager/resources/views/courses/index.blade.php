@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Danh sách Môn học') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('courses.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
            Thêm Môn học
        </a>
        <!-- Nếu có chức năng import, bạn có thể thêm button nhập từ Excel -->
        <a href="{{ route('courses.import') }}" class="px-4 py-2 bg-green-500 text-white rounded">
            Import Môn học
        </a>
    </div>
    @if($courses->count())
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white border-collapse">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left w-1/12">ID</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Mã môn học</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Tên môn học</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Số tín chỉ</th>
                        <th class="py-2 px-4 border-b text-left w-3/12">Môn tiên quyết</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $course->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $course->code }}</td>
                        <td class="py-2 px-4 border-b">{{ $course->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $course->credit }}</td>
                        <td class="py-2 px-4 border-b">
                            @if($course->prerequisites->count())
                                <ul class="list-disc ml-4">
                                    @foreach($course->prerequisites as $prerequisite)
                                        <li>{{ $prerequisite->code }} - {{ $prerequisite->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <em>Không có</em>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('courses.show', $course->id) }}" class="text-blue-600 hover:underline">Xem</a>
                            <a href="{{ route('courses.edit', $course->id) }}" class="text-yellow-600 hover:underline ml-2">Sửa</a>
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="inline-block ml-2">
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
        <p>Không có dữ liệu môn học nào.</p>
    @endif
</div>
@endsection
