@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Danh sách Lịch hẹn</h1>

@if (Auth::user()->role === 'patient')
    <a href="{{ route('appointments.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Đặt lịch hẹn mới</a>
@endif

<div class="bg-white shadow-md rounded-lg p-4">
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                @if (Auth::user()->role !== 'patient')
                    <th class="py-2 px-4 border-b text-left">Bệnh nhân</th>
                @endif
                <th class="py-2 px-4 border-b text-left">Bác sĩ</th>
                <th class="py-2 px-4 border-b text-left">Chuyên khoa</th>
                <th class="py-2 px-4 border-b text-left">Ngày hẹn</th>
                <th class="py-2 px-4 border-b text-left">Thời gian hẹn</th>
                <th class="py-2 px-4 border-b text-left">Trạng thái</th>
                <th class="py-2 px-4 border-b">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appointments as $appointment)
            <tr>
                <td class="py-2 px-4 border-b text-center">{{ $appointment->id }}</td>
                @if (Auth::user()->role !== 'patient')
                    <td class="py-2 px-4 border-b">{{ $appointment->patient->name }}</td>
                @endif
                <td class="py-2 px-4 border-b">{{ $appointment->doctor->user->name }}</td>
                <td class="py-2 px-4 border-b">{{ $appointment->doctor->specialty->name ?? 'N/A' }}</td>
                <td class="py-2 px-4 border-b">{{ $appointment->appointment_date }}</td>
                <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                <td class="py-2 px-4 border-b">{{ $appointment->status }}</td>
                <td class="py-2 px-4 border-b text-center">
                    <a href="{{ route('appointments.show', $appointment->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Xem</a>
                    @if (Auth::user()->role === 'doctor' || Auth::user()->role === 'admin')
                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Sửa trạng thái</a>
                    @endif
                    @if ($appointment->status !== 'completed' && $appointment->status !== 'cancelled')
                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn này? Khung giờ sẽ được mở lại.')">Hủy</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->role === 'patient' ? '7' : '8' }}" class="py-4 px-4 text-center text-gray-500">Không có lịch hẹn nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection