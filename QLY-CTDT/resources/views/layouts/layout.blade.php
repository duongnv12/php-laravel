<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <nav>
        <div class="logo">🎓 Quản lý Đại học</div>
        <ul>
            <li><a href="{{ route('home') }}">🏠 Trang chủ</a></li>
            @auth
                @if(auth()->user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}">⚙️ Quản lý</a></li>
                @elseif(auth()->user()->role === 'teacher')
                    <li><a href="{{ route('teacher.dashboard') }}">📚 Khóa học</a></li>
                @elseif(auth()->user()->role === 'student')
                    <li><a href="{{ route('student.dashboard') }}">📝 Đăng ký môn học</a></li>
                @endif
                <li><a href="{{ route('logout') }}">🚪 Đăng xuất</a></li>
            @else
                <li><a href="{{ route('login') }}">🔑 Đăng nhập</a></li>
            @endauth
        </ul>
    </nav>

    <div class="content">
        @yield('content')
    </div>

</body>
</html>
