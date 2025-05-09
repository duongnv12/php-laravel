@extends('layouts.layout')

@section('title', 'Thêm Khóa học')

@section('content')
    <h2>Thêm Khóa học</h2>
    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Tên khóa học" required>
        <input type="number" name="credits" placeholder="Số tín chỉ" required>
        <input type="text" name="instructor" placeholder="Giảng viên" required>
        <button type="submit">Thêm Khóa học</button>
    </form>
@endsection
