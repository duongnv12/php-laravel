@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Import Danh sách Sinh viên') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-xl mx-auto bg-white shadow sm:rounded-lg p-6">
        @if (session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form upload file Excel -->
        <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="file" class="block text-gray-700">
                    Chọn file Excel (xlsx, xls, csv):
                </label>
                <input type="file" name="file" id="file" class="border rounded w-full px-3 py-2" required>
            </div>
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">
                Import Sinh viên
            </button>
        </form>

        <!-- Link quay lại danh sách sinh viên -->
        <div class="mt-4">
            <a href="{{ route('students.index') }}" class="text-blue-600 hover:underline">
                Quay lại danh sách sinh viên
            </a>
        </div>
    </div>
</div>
@endsection
