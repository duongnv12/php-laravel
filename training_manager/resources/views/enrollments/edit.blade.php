@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Cập nhật tiến độ học tập') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="mb-4">
        <a href="{{ route('enrollments.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
            Trở về danh sách đăng ký
        </a>
    </div>
    <div class="bg-white p-6 rounded shadow-md">
        <h3 class="text-2xl font-bold mb-4">
            {{ $enrollment->student->name }} - {{ $enrollment->course->name }}
        </h3>
        <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="status" class="block text-gray-700">Trạng thái</label>
                <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                    <option value="registered" {{ $enrollment->status == 'registered' ? 'selected' : '' }}>Đăng ký</option>
                    <option value="completed" {{ $enrollment->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                    <option value="failed" {{ $enrollment->status == 'failed' ? 'selected' : '' }}>Thất bại</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="grade" class="block text-gray-700">Điểm số (nếu có)</label>
                <input type="number" step="0.1" min="0" max="10" name="grade" id="grade"
                       class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                       value="{{ $enrollment->grade }}">
            </div>
            
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                Cập nhật
            </button>
        </form>
    </div>
</div>
@endsection
