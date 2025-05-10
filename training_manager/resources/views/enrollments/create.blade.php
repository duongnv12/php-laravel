@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Đăng ký Môn học') }}
    </h2>
@endsection

@section('content')
    <div class="container mx-auto py-8">
        <div class="mb-4">
            <a href="{{ route('enrollments.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                Trở về danh sách đăng ký
            </a>
        </div>

        <div class="bg-white p-6 rounded shadow-md">
            <form action="{{ route('enrollments.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="course_id" class="block text-gray-700">Chọn Môn học</label>
                    <select name="course_id" id="course_id" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                        <option value="">-- Chọn Môn học --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="semester_id" class="block text-gray-700">Chọn kỳ học</label>
                    <select name="semester_id" id="semester_id" class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                        required>
                        <option value="">-- Chọn kỳ học --</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}">{{ $semester->name }} ({{ date('d/m/Y', strtotime($semester->start_date)) }}
                                - {{ date('d/m/Y', strtotime($semester->end_date)) }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
                    Đăng ký
                </button>
            </form>
        </div>
    </div>
@endsection
