@extends('layouts.app')

@section('title', 'Thêm Sinh Viên')

@section('content')
    <h1>Thêm Sinh Viên Mới</h1>
    <form method="POST" action="{{ route('students.store') }}">
        @csrf
        <label for="name">Họ và tên:</label>
        <input type="text" name="name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="student_code">Mã sinh viên:</label>
        <input type="text" name="student_code" required>

        <label for="curriculum_id">Chương trình đào tạo:</label>
        <select name="curriculum_id">
            @foreach ($curriculums as $curriculum)
                <option value="{{ $curriculum->id }}">{{ $curriculum->name }}</option>
            @endforeach
        </select>

        <button type="submit">Thêm Sinh Viên</button>
    </form>
@endsection