@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Danh sách Tiến độ học tập') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="mb-4">
        <a href="{{ route('progresses.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Thêm tiến độ mới</a>
    </div>
    @if($progresses->count())
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed bg-white border-collapse">
                <thead>
                    <tr>
                        <!-- Cột ID nhỏ gọn -->
                        <th class="py-2 px-4 border-b text-left w-1/12">ID</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Sinh viên</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Khóa học</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Điểm</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Trạng thái</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($progresses as $progress)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $progress->id }}</td>
                        <td class="py-2 px-4 border-b">
                            {{ $progress->student ? $progress->student->name : '' }}
                        </td>
                        <td class="py-2 px-4 border-b">
                            {{ $progress->course ? $progress->course->title : '' }}
                        </td>
                        <td class="py-2 px-4 border-b">{{ $progress->score }}</td>
                        <td class="py-2 px-4 border-b">{{ $progress->status }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('progresses.show', $progress->id) }}" class="text-blue-600 hover:underline">Xem</a>
                            <a href="{{ route('progresses.edit', $progress->id) }}" class="text-yellow-600 hover:underline ml-2">Sửa</a>
                            <form action="{{ route('progresses.destroy', $progress->id) }}" method="POST" class="inline-block ml-2">
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
        <p>Không có dữ liệu tiến độ nào.</p>
    @endif
</div>
@endsection
