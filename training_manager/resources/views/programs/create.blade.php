@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Tạo mới Chương trình đào tạo') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="mb-4">
        <a href="{{ route('programs.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
            Trở về danh sách chương trình đào tạo
        </a>
    </div>
    <div class="bg-white p-6 rounded shadow-md">
        <form action="{{ route('programs.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Tên chương trình đào tạo</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Mô tả</label>
                <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
            </div>
            <div class="mb-4">
                <label for="course_ids" class="block text-gray-700">Chọn Môn học (có thể chọn nhiều)</label>
                <select name="course_ids[]" id="course_ids" class="mt-1 block w-full border border-gray-300 rounded-md p-2" multiple>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                Lưu Chương trình đào tạo
            </button>
        </form>
    </div>
</div>
@endsection
