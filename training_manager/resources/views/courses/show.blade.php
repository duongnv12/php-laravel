@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chi tiết Khóa học') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white shadow-md rounded p-6">
        <p class="mb-4"><strong>ID:</strong> {{ $course->id }}</p>
        <p class="mb-4"><strong>Tiêu đề:</strong> {{ $course->title }}</p>
        <p class="mb-4"><strong>Miêu tả:</strong> {{ $course->description }}</p>
        <p class="mb-4"><strong>Ngày bắt đầu:</strong> {{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('d-m-Y') : '' }}</p>
        <p class="mb-4"><strong>Ngày kết thúc:</strong> {{ $course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('d-m-Y') : '' }}</p>
        <div>
            <a href="{{ route('courses.edit', $course->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Chỉnh sửa</a>
            <a href="{{ route('courses.index') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded">Quay lại</a>
        </div>
    </div>
</div>
@endsection
