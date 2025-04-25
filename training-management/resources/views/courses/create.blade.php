@extends('layouts.app')

@section('title', 'Thêm Môn Học')

@section('content')
    <h1>Thêm Môn Học Mới</h1>
    <form method="POST" action="{{ route('courses.store') }}">
        @csrf
        <label for="name">Tên môn học:</label>
        <input type="text" name="name" required>

        <label for="credits">Số tín chỉ:</label>
        <input type="number" name="credits" required>

        <label for="instructor">Giảng viên:</label>
        <input type="text" name="instructor" required>

        <label for="curriculum_id">Chương trình đào tạo:</label>
        <select name="curriculum_id">
            @foreach ($curriculums as $curriculum)
                <option value="{{ $curriculum->id }}">{{ $curriculum->name }}</option>
            @endforeach
        </select>

        <button type="submit">Thêm Môn Học</button>
    </form>
@endsection