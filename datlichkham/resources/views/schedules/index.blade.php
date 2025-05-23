@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Danh sách Lịch làm việc</h1>

@if (Auth::user()->role === 'doctor' || Auth::user()->role === 'admin')
    <a href="{{ route('schedules.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Thêm Lịch làm việc mới</a>
@endif

<div class="bg-white shadow-md rounded-lg p-4">
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b text-left">Bác sĩ</th>
                <th class="py-2 px-4 border-b text-left">Ngày</th>
                <th class="py-2 px-4 border-b text-left">Thời gian bắt đầu</th>
                <th class="py-2 px-4 border-b text-left">Thời gian kết thúc</th>
                <th class="py-2 px-4 border-b text-left">Trạng thái</th>
                <th class="py-2 px-4 border-b">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($schedules as $schedule)
            <tr>
                <td class="py-2 px-4 border-b text-center">{{ $schedule->id }}</td>
                <td class="py-2 px-4 border-b">{{ $schedule->doctor->user->name }}</td>
                <td class="py-2 px-4 border-b">{{ $schedule->date }}</td>
                <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                <td class="py-2 px-4 border-b">{{ $schedule->status }}</td>
                <td class="py-2 px-4 border-b text-center">
                    <a href="{{ route('schedules.show', $schedule->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Xem</a>
                    @if (Auth::user()->role === 'doctor' && Auth::user()->doctor->id === $schedule->doctor_id || Auth::user()->role === 'admin')
                        <a href="{{ route('schedules.edit', $schedule->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Sửa</a>
                        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bạn có chắc chắn muốn xóa lịch làm việc này?')">Xóa</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-4 px-4 text-center text-gray-500">Không có lịch làm việc nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection