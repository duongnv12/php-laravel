@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Tạo mới Môn học') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="mb-4">
        <a href="{{ route('courses.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
            Trở về danh sách Môn học
        </a>
    </div>
    <div class="bg-white p-6 rounded shadow-md">
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="code" class="block text-gray-700">Mã môn học</label>
                <input type="text" name="code" id="code" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Tên môn học</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <div class="mb-4">
                <label for="credit" class="block text-gray-700">Số tín chỉ</label>
                <input type="number" step="0.1" name="credit" id="credit" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Mô tả</label>
                <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
            </div>
            <div class="mb-4">
                <label for="prerequisites" class="block text-gray-700">
                    Chọn môn tiên quyết (có thể chọn nhiều)
                </label>
                <select name="prerequisites[]" id="prerequisites" class="mt-1 block w-full border border-gray-300 rounded-md p-2" multiple>
                    @foreach($courses as $courseOption)
                        <option value="{{ $courseOption->id }}">{{ $courseOption->code }} - {{ $courseOption->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                Lưu Môn học
            </button>
        </form>
    </div>
</div>
@endsection
