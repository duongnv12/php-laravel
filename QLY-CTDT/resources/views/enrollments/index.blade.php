@extends('layouts.layout')

@section('title', 'Danh sách Đăng ký Môn học')

@section('content')
    <h2>Danh sách Đăng ký Môn học</h2>
    <a href="{{ route('enrollments.create') }}" class="button">➕ Thêm Đăng ký</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Sinh viên</th>
                <th>Khóa học</th>
                <th>Điểm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $enrollment)
                <tr>
                    <td>{{ $enrollment->id }}</td>
                    <td>{{ $enrollment->student->name }}</td>
                    <td>{{ $enrollment->course->name }}</td>
                    <td>{{ $enrollment->grade ?? 'Chưa có điểm' }}</td>
                    <td>
                        <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa đăng ký này?')">🗑 Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
