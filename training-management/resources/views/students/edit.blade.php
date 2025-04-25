@extends('layouts.app')

@section('title', 'Chỉnh sửa Sinh Viên')

@section('content')
    <h1>Chỉnh sửa Sinh Viên</h1>
    <form method="POST" action="{{ route('students.update', $student->id) }}">
        @csrf
        @method('PUT')

        <label for="name">Họ và tên:</label>
        <input type="text" name="name" value="{{ $student->name }}" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ $student->email }}" required>

        <label for="student_code">Mã sinh viên:</label>
        <input type="text" name="student_code" value="{{ $student->student_code }}" required>

        <label for="curriculum_id">Chương trình đào tạo:</label>
        <select name="curriculum_id">
            @foreach ($curriculums as $curriculum)
                <option value="{{ $curriculum->id }}" {{ $student->curriculum_id == $curriculum->id ? 'selected' : '' }}>
                    {{ $curriculum->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Lưu thay đổi</button>
    </form>
@endsection