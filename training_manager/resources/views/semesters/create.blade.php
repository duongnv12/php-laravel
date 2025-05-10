@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Thêm Kỳ học mới') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('semesters.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Tên kỳ học</label>
                    <input type="text" name="name" id="name" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label for="start_date" class="block text-gray-700">Ngày bắt đầu</label>
                    <input type="date" name="start_date" id="start_date" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label for="end_date" class="block text-gray-700">Ngày kết thúc</label>
                    <input type="date" name="end_date" id="end_date" class="w-full border rounded p-2" required>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Lưu</button>
            </form>
        </div>
    </div>
</div>
@endsection
