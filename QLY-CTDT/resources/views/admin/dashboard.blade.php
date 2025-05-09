@extends('layouts.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <h2>🔧 Quản lý Hệ thống</h2>
    <p>Chào mừng Admin! Bạn có thể quản lý người dùng, khóa học và đăng ký môn học.</p>

    <div class="admin-buttons">
        <a href="{{ route('users.index') }}" class="button">👥 Quản lý Người dùng</a>
        <a href="{{ route('courses.index') }}" class="button">📚 Quản lý Khóa học</a>
        <a href="{{ route('enrollments.index') }}" class="button">📝 Quản lý Đăng ký Môn học</a>
    </div>
@endsection
