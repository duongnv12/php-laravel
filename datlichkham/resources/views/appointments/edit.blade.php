@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Chỉnh sửa trạng thái Lịch hẹn</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Bệnh nhân:</strong>
            <p class="text-gray-900">{{ $appointment->patient->name }}</p>
        </div>
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Bác sĩ:</strong>
            <p class="text-gray-900">{{ $appointment->doctor->user->name }}</p>
        </div>
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Ngày hẹn:</strong>
            <p class="text-gray-900">{{ $appointment->appointment_date }}</p>
        </div>
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Thời gian hẹn:</strong>
            <p class="text-gray-900">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</p>
        </div>
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Lý do khám:</strong>
            <p class="text-gray-900">{{ $appointment->reason ?? 'Không có' }}</p>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Trạng thái:</label>
            <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror" required>
                <option value="pending" {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                <option value="confirmed" {{ old('status', $appointment->status) == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cập nhật trạng thái</button>
            <a href="{{ route('appointments.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Hủy</a>
        </div>
    </form>
</div>
@endsection