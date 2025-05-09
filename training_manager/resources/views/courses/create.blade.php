@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Thêm Khóa học mới') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Tiêu đề</label>
            <input type="text" id="title" name="title" class="border rounded w-full px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Miêu tả</label>
            <textarea id="description" name="description" class="border rounded w-full px-3 py-2" rows="4"></textarea>
        </div>
        <div class="mb-4">
            <label for="start_date" class="block text-gray-700">Ngày bắt đầu</label>
            <input type="date" id="start_date" name="start_date" class="border rounded w-full px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="end_date" class="block text-gray-700">Ngày kết thúc</label>
            <input type="date" id="end_date" name="end_date" class="border rounded w-full px-3 py-2">
        </div>
        <div>
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Lưu</button>
            <a href="{{ route('courses.index') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded">Hủy</a>
        </div>
    </form>
</div>
@endsection
