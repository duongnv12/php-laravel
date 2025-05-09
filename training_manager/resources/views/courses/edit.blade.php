@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chỉnh sửa Khóa học') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Tiêu đề</label>
            <input type="text" id="title" name="title" value="{{ old('title', $course->title) }}" class="border rounded w-full px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Miêu tả</label>
            <textarea id="description" name="description" class="border rounded w-full px-3 py-2" rows="4">{{ old('description', $course->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label for="start_date" class="block text-gray-700">Ngày bắt đầu</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('Y-m-d') : '') }}" class="border rounded w-full px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="end_date" class="block text-gray-700">Ngày kết thúc</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('Y-m-d') : '') }}" class="border rounded w-full px-3 py-2">
        </div>
        <div>
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Cập nhật</button>
            <a href="{{ route('courses.index') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded">Hủy</a>
        </div>
    </form>
</div>
@endsection
