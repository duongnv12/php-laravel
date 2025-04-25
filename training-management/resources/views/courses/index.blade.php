@extends('layouts.app')

@section('title', 'Danh sách môn học')

@section('content')
    <h1>Danh sách môn học</h1>
    <table>
        <tr>
            <th>Tên môn học</th>
            <th>Số tín chỉ</th>
            <th>Giảng viên</th>
        </tr>
        @foreach ($courses as $course)
            <tr>
                <td>{{ $course->name }}</td>
                <td>{{ $course->credits }}</td>
                <td>{{ $course->instructor }}</td>
            </tr>
        @endforeach
    </table>
@endsection