@extends('layouts.layout')

@section('title', 'Trang Chủ')

@section('content')
    <div class="welcome-container">
        <h1>🎓 Hệ thống Quản lý Đại học</h1>
        <p>Quản lý sinh viên, giảng viên và khóa học một cách dễ dàng.</p>

        <div class="buttons">
            <a href="{{ route('login') }}" class="button primary">🔑 Đăng nhập</a>
            <a href="{{ route('home') }}" class="button secondary">📖 Xem thông tin</a>
        </div>
    </div>
@endsection
