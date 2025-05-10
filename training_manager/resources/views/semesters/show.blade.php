@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chi tiết Kỳ học') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Hiển thị thông tin chi tiết của kỳ học -->
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium mb-4">Thông tin Kỳ học</h3>
            <p><strong>ID:</strong> {{ $semester->id }}</p>
            <p><strong>Tên kỳ học:</strong> {{ $semester->name }}</p>
            <p>
                <strong>Ngày bắt đầu:</strong> 
                {{ \Carbon\Carbon::parse($semester->start_date)->format('d/m/Y') }}
            </p>
            <p>
                <strong>Ngày kết thúc:</strong> 
                {{ \Carbon\Carbon::parse($semester->end_date)->format('d/m/Y') }}
            </p>
            <div class="mt-4">
                <a href="{{ route('semesters.edit', $semester->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded">
                    Chỉnh sửa
                </a>
                <a href="{{ route('semesters.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                    Trở về danh sách
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
