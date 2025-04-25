@extends('layouts.app')

@section('title', 'Danh sách sinh viên')

@section('content')
    <h1>Danh sách sinh viên</h1>
    <table>
        <tr>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Mã sinh viên</th>
            <th>Chương trình đào tạo</th>
            <th>Hành động</th>
        </tr>
        @foreach ($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->student_code }}</td>
                <td>{{ $student->curriculum->name }}</td>
                <td>
                    <a href="{{ route('students.edit', $student->id) }}">Chỉnh sửa</a>
                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection