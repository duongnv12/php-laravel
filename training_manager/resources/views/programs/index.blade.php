@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Danh sách Chương trình đào tạo') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('programs.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
            Thêm Chương trình đào tạo
        </a>
    </div>
    @if($programs->count())
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white border-collapse">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left w-1/12">ID</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Tên</th>
                        <th class="py-2 px-4 border-b text-left w-4/12">Mô tả</th>
                        <th class="py-2 px-4 border-b text-left w-3/12">Danh sách Môn học</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programs as $program)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $program->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $program->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $program->description }}</td>
                        <td class="py-2 px-4 border-b">
                            @if($program->courses->count())
                                <ul class="list-disc ml-4">
                                    @foreach($program->courses as $course)
                                        <li>{{ $course->code }} - {{ $course->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <em>Chưa có môn học</em>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('programs.show', $program->id) }}" class="text-blue-600 hover:underline">Xem</a>
                            <a href="{{ route('programs.edit', $program->id) }}" class="text-yellow-600 hover:underline ml-2">Sửa</a>
                            <form action="{{ route('programs.destroy', $program->id) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Bạn có chắc muốn xóa chương trình này không?')" class="text-red-600 hover:underline">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Không có dữ liệu chương trình đào tạo nào.</p>
    @endif
</div>
@endsection
