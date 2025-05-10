@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chỉnh sửa Kỳ học') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Form chỉnh sửa kỳ học -->
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('semesters.update', $semester->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Tên kỳ học</label>
                    <input type="text" name="name" id="name" value="{{ $semester->name }}" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label for="start_date" class="block text-gray-700">Ngày bắt đầu</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $semester->start_date }}" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label for="end_date" class="block text-gray-700">Ngày kết thúc</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $semester->end_date }}" class="w-full border rounded p-2" required>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                    Cập nhật
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
