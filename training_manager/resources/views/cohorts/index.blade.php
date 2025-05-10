@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Danh sách Niên khóa') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('cohorts.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Thêm Niên khóa</a>
    </div>
    @if($cohorts->count())
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-200 shadow-sm rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-600">ID</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-600">Tên Niên khóa</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-600">Năm bắt đầu</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-600">Năm kết thúc</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-600">Chương trình đào tạo</th>
                        <th class="py-3 px-4 border-b text-left font-medium text-gray-600">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($cohorts as $cohort)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 border-b text-gray-700">{{ $cohort->id }}</td>
                        <td class="py-3 px-4 border-b text-gray-700">{{ $cohort->name }}</td>
                        <td class="py-3 px-4 border-b text-gray-700">{{ $cohort->start_year }}</td>
                        <td class="py-3 px-4 border-b text-gray-700">{{ $cohort->end_year }}</td>
                        <td class="py-3 px-4 border-b text-gray-700">
                            @if($cohort->programs->count())
                                <ul class="list-disc pl-5">
                                    @foreach($cohort->programs as $program)
                                        <li>{{ $program->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <em class="text-gray-500">Chưa có chương trình</em>
                            @endif
                        </td>
                        <td class="py-3 px-4 border-b text-gray-700">
                            <a href="{{ route('cohorts.show', $cohort->id) }}" class="text-blue-500 hover:underline">Xem</a>
                            <a href="{{ route('cohorts.edit', $cohort->id) }}" class="text-yellow-500 hover:underline ml-2">Sửa</a>
                            <form action="{{ route('cohorts.destroy', $cohort->id) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')" class="text-red-500 hover:underline">
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
        <p class="text-gray-500">Không có dữ liệu niên khóa nào.</p>
    @endif
</div>
@endsection
