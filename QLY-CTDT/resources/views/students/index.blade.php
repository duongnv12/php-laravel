@extends('layouts.layout')

@section('title', 'Danh sách Sinh viên')

@section('content')
    <h2>Danh sách Sinh viên</h2>
    <a href="{{ route('students.create') }}" class="button">➕ Thêm Sinh viên</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ Tên</th>
                <th>Lớp</th>
                <th>Ngày Sinh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->class }}</td>
                    <td>{{ $student->birthdate }}</td>
                    <td>
                        <a href="{{ route('students.edit', $student->id) }}">✏️ Sửa</a> | 
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
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
