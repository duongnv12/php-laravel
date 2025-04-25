@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    <h1>Chào mừng bạn đến với hệ thống quản lý đào tạo!</h1>
    <p>Hãy chọn chức năng bạn muốn sử dụng:</p>
    <a href="{{ route('courses.index') }}">Danh sách môn học</a>
    <a href="{{ route('students.index') }}">Danh sách sinh viên</a>
@endsection