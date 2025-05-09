@extends('layouts.layout')

@section('title', 'Chỉnh sửa Sinh viên')

@section('content')
    <h2>Chỉnh sửa Sinh viên</h2>
    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $student->name }}" required>
        <input type="date" name="birthdate" value="{{ $student->birthdate }}" required>
        <input type="text" name="class" value="{{ $student->class }}" required>
        <button type="submit">Cập nhật</button>
    </form>
@endsection
