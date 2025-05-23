@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Chi tiết Lịch hẹn</h1>

<div class="bg-white shadow-md rounded-lg p-6 mb-4">
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">ID Lịch hẹn:</strong>
        <p class="text-gray-900">{{ $appointment->id }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Bệnh nhân:</strong>
        <p class="text-gray-900">{{ $appointment->patient->name }} ({{ $appointment->patient->email }})</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Bác sĩ:</strong>
        <p class="text-gray-900">{{ $appointment->doctor->user->name }} (Chuyên khoa: {{ $appointment->doctor->specialty->name ?? 'N/A' }})</p>
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
        <strong class="block text-gray-700 text-sm font-bold mb-2">Lý do khám bệnh:</strong>
        <p class="text-gray-900">{{ $appointment->reason ?? 'Không có' }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Trạng thái:</strong>
        <p class="text-gray-900">{{ $appointment->status }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Ngày đặt:</strong>
        <p class="text-gray-900">{{ $appointment->created_at->format('d/m/Y H:i:s') }}</p>
    </div>
    <div class="mb-4">
        <strong class="block text-gray-700 text-sm font-bold mb-2">Cập nhật cuối:</strong>
        <p class="text-gray-900">{{ $appointment->updated_at->format('d/m/Y H:i:s') }}</p>
    </div>
</div>

<div class="flex space-x-2">
    @if (Auth::user()->role === 'doctor' || Auth::user()->role === 'admin')
        <a href="{{ route('appointments.edit', $appointment->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Sửa trạng thái</a>
    @endif
    @if ($appointment->status !== 'completed' && $appointment->status !== 'cancelled')
        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn này? Khung giờ sẽ được mở lại.')">Hủy</button>
        </form>
    @endif
    <a href="{{ route('appointments.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Quay lại</a>
</div>
@endsection