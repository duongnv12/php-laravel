@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Import Môn học') }}
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
        <form action="{{ route('courses.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="file" class="block text-gray-700">Chọn file Excel cần import</label>
                <input type="file" name="file" id="file" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                Import Môn học
            </button>
        </form>
    </div>
</div>
@endsection
