@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chi tiết Tiến độ') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white shadow-md rounded p-6">
        <p class="mb-4"><strong>ID:</strong> {{ $progress->id }}</p>
        <p class="mb-4">
            <strong>Sinh viên:</strong>
            {{ $progress->student ? $progress->student->name : '' }}
        </p>
        <p class="mb-4">
            <strong>Khóa học:</strong>
            {{ $progress->course ? $progress->course->title : '' }}
        </p>
        <p class="mb-4"><strong>Điểm:</strong> {{ $progress->score }}</p>
        <p class="mb-4"><strong>Trạng thái:</strong> {{ $progress->status }}</p>
        <div>
            <a href="{{ route('progresses.edit', $progress->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Chỉnh sửa</a>
            <a href="{{ route('progresses.index') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded">Quay lại</a>
        </div>
    </div>
</div>
@endsection
