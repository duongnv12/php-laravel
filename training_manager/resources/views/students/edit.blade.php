@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chỉnh sửa Sinh viên') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Tên</label>
            <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" class="border rounded w-full px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" class="border rounded w-full px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-gray-700">Số điện thoại</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $student->phone) }}" class="border rounded w-full px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="dob" class="block text-gray-700">Ngày sinh</label>
            <input type="date" name="dob" id="dob" value="{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d-m-Y') : '' }}" class="border rounded w-full px-3 py-2">
        </div>
        <div>
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Cập nhật</button>
            <a href="{{ route('students.index') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded">Hủy</a>
        </div>
    </form>
</div>
@endsection
