@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Thêm Tiến độ mới') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <form action="{{ route('progresses.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="student_id" class="block text-gray-700">Sinh viên</label>
            <select name="student_id" id="student_id" class="border rounded w-full px-3 py-2" required>
                <option value="">-- Chọn Sinh viên --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="course_id" class="block text-gray-700">Khóa học</label>
            <select name="course_id" id="course_id" class="border rounded w-full px-3 py-2" required>
                <option value="">-- Chọn Khóa học --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="score" class="block text-gray-700">Điểm</label>
            <input type="number" step="0.01" name="score" id="score" class="border rounded w-full px-3 py-2" placeholder="Nhập điểm nếu có">
        </div>
        <div class="mb-4">
            <label for="status" class="block text-gray-700">Trạng thái</label>
            <input type="text" name="status" id="status" class="border rounded w-full px-3 py-2" placeholder="VD: pending, completed" required>
        </div>
        <div>
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Lưu</button>
            <a href="{{ route('progresses.index') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded">Hủy</a>
        </div>
    </form>
</div>
@endsection
