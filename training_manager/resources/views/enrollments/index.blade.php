@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Danh sách Đăng ký Học') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    @if(session('success'))
        <div class="bg-green-200 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('enrollments.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
            Đăng ký môn học mới
        </a>
    </div>

    @if($enrollments->count())
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white border-collapse">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">ID</th>
                        <th class="py-2 px-4 border-b text-left">Sinh viên</th>
                        <th class="py-2 px-4 border-b text-left">Môn học</th>
                        <th class="py-2 px-4 border-b text-left">Trạng thái</th>
                        <th class="py-2 px-4 border-b text-left">Điểm</th>
                        <th class="py-2 px-4 border-b text-left">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrollments as $enrollment)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $enrollment->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $enrollment->student->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $enrollment->course->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $enrollment->status }}</td>
                        <td class="py-2 px-4 border-b">{{ $enrollment->grade ?? 'Chưa chấm' }}</td>
                        <td class="py-2 px-4 border-b">
                            <a href="{{ route('enrollments.edit', $enrollment->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">
                                Chỉnh sửa
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Chưa có đăng ký học nào.</p>
    @endif
</div>
@endsection
