@extends('layouts.layout')

@section('title', 'Thêm Sinh viên')

@section('content')
    <h2>Thêm Sinh viên</h2>
    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Họ tên" required>
        <input type="date" name="birthdate" required>
        <input type="text" name="class" placeholder="Lớp học" required>
        <button type="submit">Thêm Sinh viên</button>
    </form>
@endsection
