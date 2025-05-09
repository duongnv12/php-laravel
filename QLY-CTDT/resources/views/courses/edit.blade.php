@extends('layouts.layout')

@section('title', 'Chỉnh sửa Khóa học')

@section('content')
    <h2>Chỉnh sửa Khóa học</h2>
    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $course->name }}" required>
        <input type="number" name="credits" value="{{ $course->credits }}" required>
        <input type="text" name="instructor" value="{{ $course->instructor }}" required>
        <button type="submit">Cập nhật</button>
    </form>
@endsection
