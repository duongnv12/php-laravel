@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Thêm Lịch làm việc mới</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('schedules.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="doctor_id" class="block text-gray-700 text-sm font-bold mb-2">Bác sĩ:</label>
            <select name="doctor_id" id="doctor_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('doctor_id') border-red-500 @enderror" {{ Auth::user()->role === 'doctor' ? 'readonly' : '' }} required>
                @if (Auth::user()->role === 'patient')
                    <option value="">Bạn không có quyền chọn bác sĩ</option>
                @else
                    <option value="">Chọn bác sĩ</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ (Auth::user()->role === 'doctor' && Auth::user()->doctor->id === $doctor->id) ? 'selected' : '' }} {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->user->name }} ({{ $doctor->specialty->name ?? 'N/A' }})
                        </option>
                    @endforeach
                @endif
            </select>
            @error('doctor_id')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Ngày:</label>
            <input type="date" name="date" id="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('date') border-red-500 @enderror" value="{{ old('date') }}" required>
            @error('date')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">Thời gian bắt đầu:</label>
            <input type="time" name="start_time" id="start_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('start_time') border-red-500 @enderror" value="{{ old('start_time') }}" required>
            @error('start_time')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="end_time" class="block text-gray-700 text-sm font-bold mb-2">Thời gian kết thúc:</label>
            <input type="time" name="end_time" id="end_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('end_time') border-red-500 @enderror" value="{{ old('end_time') }}" required>
            @error('end_time')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Thêm Lịch làm việc</button>
            <a href="{{ route('schedules.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Hủy</a>
        </div>
    </form>
</div>
@endsection