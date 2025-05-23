@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Chi tiết Lịch làm việc</h1>

<div class="bg-white shadow-md rounded-lg p-6 mb-4">
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">ID:</strong>
        <p class="text-gray-900">{{ $schedule->id }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Bác sĩ:</strong>
        <p class="text-gray-900">{{ $schedule->doctor->user->name }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Chuyên khoa:</strong>
        <p class="text-gray-900">{{ $schedule->doctor->specialty->name ?? 'N/A' }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Ngày:</strong>
        <p class="text-gray-900">{{ $schedule->date }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Thời gian:</strong>
        <p class="text-gray-900">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Trạng thái:</strong>
        <p class="text-gray-900">{{ $schedule->status }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Ngày tạo:</strong>
        <p class="text-gray-900">{{ $schedule->created_at->format('d/m/Y H:i:s') }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Cập nhật cuối:</strong>
        <p class="text-gray-900">{{ $schedule->updated_at->format('d/m/Y H:i:s') }}</p>
    </div>
</div>

<div class="flex space-x-2">
    @if (Auth::user()->role === 'doctor' && Auth::user()->doctor->id === $schedule->doctor_id || Auth::user()->role === 'admin')
        <a href="{{ route('schedules.edit', $schedule->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Sửa</a>
        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Bạn có chắc chắn muốn xóa lịch làm việc này?')">Xóa</button>
        </form>
    @endif
    <a href="{{ route('schedules.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Quay lại</a>
</div>
@endsection