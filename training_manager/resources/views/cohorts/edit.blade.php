@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chỉnh sửa Niên khóa') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="mb-4">
        <a href="{{ route('cohorts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
            Trở về danh sách Niên khóa
        </a>
    </div>
    <div class="bg-white p-6 rounded shadow-md">
        <form action="{{ route('cohorts.update', $cohort->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Tên Niên khóa</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2" 
                       value="{{ old('name', $cohort->name) }}" required>
            </div>
            <div class="mb-4">
                <label for="start_year" class="block text-gray-700">Năm bắt đầu</label>
                <input type="number" name="start_year" id="start_year" class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                       value="{{ old('start_year', $cohort->start_year) }}">
            </div>
            <div class="mb-4">
                <label for="end_year" class="block text-gray-700">Năm kết thúc</label>
                <input type="number" name="end_year" id="end_year" class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                       value="{{ old('end_year', $cohort->end_year) }}">
            </div>
            <div class="mb-4">
                <label for="program_ids" class="block text-gray-700">
                    Chọn Chương trình đào tạo (có thể chọn nhiều)
                </label>
                <select name="program_ids[]" id="program_ids" class="mt-1 block w-full border border-gray-300 rounded-md p-2" multiple>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}"
                            {{ in_array($program->id, old('program_ids', $cohort->programs->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $program->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                Cập nhật Niên khóa
            </button>
        </form>
    </div>
</div>
@endsection
