@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Thông tin Sinh viên') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white shadow-md rounded p-6">
        <p class="mb-4"><strong>ID:</strong> {{ $student->id }}</p>
        <p class="mb-4"><strong>Tên:</strong> {{ $student->name }}</p>
        <p class="mb-4"><strong>Email:</strong> {{ $student->email }}</p>
        <p class="mb-4"><strong>Số điện thoại:</strong> {{ $student->phone }}</p>
        <p class="mb-4"><strong>Ngày sinh:</strong> {{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d-m-Y') : '' }}</p>
        <div>
            <a href="{{ route('students.edit', $student->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Chỉnh sửa</a>
            <a href="{{ route('students.index') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded">Quay lại</a>
        </div>
    </div>
</div>
@endsection
