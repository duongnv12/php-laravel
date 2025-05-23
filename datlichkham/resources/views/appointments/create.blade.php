@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Đặt lịch hẹn mới</h1>

<div class="bg-white shadow-md rounded-lg p-6">
    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="doctor_id" class="block text-gray-700 text-sm font-bold mb-2">Chọn Bác sĩ:</label>
            <select name="doctor_id" id="doctor_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('doctor_id') border-red-500 @enderror" required>
                <option value="">-- Chọn Bác sĩ --</option>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->user->name }} (Chuyên khoa: {{ $doctor->specialty->name ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
            @error('doctor_id')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Chọn Ngày:</label>
            <input type="date" name="date" id="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('date') border-red-500 @enderror" value="{{ old('date') }}" required>
            @error('date')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="schedule_id" class="block text-gray-700 text-sm font-bold mb-2">Chọn Khung giờ:</label>
            <select name="schedule_id" id="schedule_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('schedule_id') border-red-500 @enderror" required>
                <option value="">-- Chọn Khung giờ trống --</option>
                {{-- Options sẽ được tải bằng AJAX --}}
            </select>
            @error('schedule_id')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="reason" class="block text-gray-700 text-sm font-bold mb-2">Lý do khám bệnh (tùy chọn):</label>
            <textarea name="reason" id="reason" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('reason') border-red-500 @enderror">{{ old('reason') }}</textarea>
            @error('reason')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Đặt lịch hẹn</button>
            <a href="{{ route('appointments.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Hủy</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('doctor_id').addEventListener('change', fetchAvailableSchedules);
    document.getElementById('date').addEventListener('change', fetchAvailableSchedules);

    function fetchAvailableSchedules() {
        const doctorId = document.getElementById('doctor_id').value;
        const date = document.getElementById('date').value;
        const scheduleSelect = document.getElementById('schedule_id');

        // Clear existing options
        scheduleSelect.innerHTML = '<option value="">-- Chọn Khung giờ trống --</option>';

        if (doctorId && date) {
            fetch('/appointments/available-schedules?doctor_id=' + doctorId + '&date=' + date)
                .then(response => response.json())
                .then(schedules => {
                    if (schedules.length > 0) {
                        schedules.forEach(schedule => {
                            const option = document.createElement('option');
                            option.value = schedule.id;
                            option.textContent = `${schedule.start_time.substring(0, 5)} - ${schedule.end_time.substring(0, 5)}`;
                            scheduleSelect.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.textContent = 'Không có khung giờ trống cho ngày này.';
                        scheduleSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi lấy lịch làm việc:', error);
                    const option = document.createElement('option');
                    option.textContent = 'Có lỗi xảy ra khi tải khung giờ.';
                    scheduleSelect.appendChild(option);
                });
        }
    }

    // Call on page load if values are pre-filled (e.g., after validation error)
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('doctor_id').value && document.getElementById('date').value) {
            fetchAvailableSchedules();
        }
    });
</script>
@endsection