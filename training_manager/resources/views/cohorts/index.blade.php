@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Danh sách Niên khóa') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('cohorts.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Thêm Niên khóa</a>
        <!-- Nếu có chức năng import niên khóa, bạn có thể thêm button import ở đây -->
    </div>
    @if($cohorts->count())
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white border-collapse">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left w-1/12">ID</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Tên Niên khóa</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Năm bắt đầu</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Năm kết thúc</th>
                        <th class="py-2 px-4 border-b text-left w-3/12">Chương trình đào tạo</th>
                        <th class="py-2 px-4 border-b text-left w-2/12">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cohorts as $cohort)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $cohort->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $cohort->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $cohort->start_year }}</td>
                        <td class="py-2 px-4 border-b">{{ $cohort->end_year }}</td>
                        <td class="py-2 px-4 border-b">
                            @if($cohort->programs->count())
                                <ul>
                                    @foreach($cohort->programs as $program)
                                        <li>{{ $program->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <em>Chưa có chương trình</em>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('cohorts.show', $cohort->id) }}" class="text-blue-600 hover:underline">Xem</a>
                            <a href="{{ route('cohorts.edit', $cohort->id) }}" class="text-yellow-600 hover:underline ml-2">Sửa</a>
                            <form action="{{ route('cohorts.destroy', $cohort->id) }}" method="POST" class="inline-block ml-2">
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
        <p>Không có dữ liệu niên khóa nào.</p>
    @endif
</div>
@endsection
