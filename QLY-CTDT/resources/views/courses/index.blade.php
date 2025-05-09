@extends('layouts.layout')

@section('title', 'Danh sách Khóa học')

@section('content')
    <h2>Danh sách Khóa học</h2>
    <a href="{{ route('courses.create') }}" class="button">➕ Thêm Khóa học</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Khóa học</th>
                <th>Số tín chỉ</th>
                <th>Giảng viên</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->credits }}</td>
                    <td>{{ $course->instructor }}</td>
                    <td>
                        <a href="{{ route('courses.edit', $course->id) }}">✏️ Sửa</a> | 
                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')">🗑 Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
