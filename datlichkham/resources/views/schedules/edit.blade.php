@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Chỉnh sửa Lịch làm việc</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="doctor_id" class="block text-gray-700 text-sm font-bold mb-2">Bác sĩ:</label>
            <select name="doctor_id" id="doctor_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
                {{-- Disable để không cho sửa bác sĩ của lịch đã tạo --}}
                <option value="{{ $schedule->doctor->id }}" selected>
                    {{ $schedule->doctor->user->name }} ({{ $schedule->doctor->specialty->name ?? 'N/A' }})
                </option>
            </select>
        </div>
        <div class="mb-4">
            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Ngày:</label>
            <input type="date" name="date" id="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('date') border-red-500 @enderror" value="{{ old('date', $schedule->date) }}" required>
            @error('date')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">Thời gian bắt đầu:</label>
            <input type="time" name="start_time" id="start_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('start_time') border-red-500 @enderror" value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" required>
            @error('start_time')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="end_time" class="block text-gray-700 text-sm font-bold mb-2">Thời gian kết thúc:</label>
            <input type="time" name="end_time" id="end_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('end_time') border-red-500 @enderror" value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" required>
            @error('end_time')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Trạng thái:</label>
            <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror" required>
                <option value="available" {{ old('status', $schedule->status) == 'available' ? 'selected' : '' }}>Có sẵn</option>
                <option value="booked" {{ old('status', $schedule->status) == 'booked' ? 'selected' : '' }}>Đã đặt</option>
                <option value="unavailable" {{ old('status', $schedule->status) == 'unavailable' ? 'selected' : '' }}>Không khả dụng</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cập nhật Lịch làm việc</button>
            <a href="{{ route('schedules.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Hủy</a>
        </div>
    </form>
</div>
@endsection