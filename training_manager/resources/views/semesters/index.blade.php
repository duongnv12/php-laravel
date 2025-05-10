@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Quản lý Kỳ học') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-4">
            <a href="{{ route('semesters.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
                Thêm kỳ học mới
            </a>
        </div>
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <table class="w-full divide-y-2 divide-gray-700">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Tên kỳ</th>
                        <th class="px-4 py-2 text-left">Ngày bắt đầu</th>
                        <th class="px-4 py-2 text-left">Ngày kết thúc</th>
                        <th class="px-4 py-2 text-left">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-gray-700">
                    @foreach($semesters as $semester)
                    <tr>
                        <td class="px-4 py-2">{{ $semester->id }}</td>
                        <td class="px-4 py-2">{{ $semester->name }}</td>
                        <td class="px-4 py-2">{{ $semester->start_date }}</td>
                        <td class="px-4 py-2">{{ $semester->end_date }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('semesters.edit', $semester->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded inline-block mr-2">
                                Chỉnh sửa
                            </a>
                            <form action="{{ route('semesters.destroy', $semester->id) }}" method="POST" class="inline-block">
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
