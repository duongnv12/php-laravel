@extends('layouts.layout')

@section('title', 'Thêm Đăng ký Môn học')

@section('content')
    <h2>Thêm Đăng ký Môn học</h2>
    <form action="{{ route('enrollments.store') }}" method="POST">
        @csrf
        <label for="student_id">Chọn Sinh viên:</label>
        <select name="student_id" required>
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>

        <label for="course_id">Chọn Khóa học:</label>
        <select name="course_id" required>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
            @endforeach
        </select>

        <label for="grade">Điểm (Không bắt buộc):</label>
        <input type="number" name="grade" min="0" max="10" step="0.1">

        <button type="submit">Thêm Đăng ký</button>
    </form>
@endsection
