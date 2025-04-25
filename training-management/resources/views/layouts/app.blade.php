<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav>
        <a href="{{ route('courses.index') }}">Môn học</a>
        <a href="{{ route('students.index') }}">Sinh viên</a>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>