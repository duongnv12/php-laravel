@extends('layouts.layout')

@section('title', 'Thêm Chương trình Đào tạo')

@section('content')
    <h2>Thêm Chương trình Đào tạo</h2>
    <form action="{{ route('programs.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Tên chương trình" required>
        <textarea name="description" placeholder="Mô tả chương trình"></textarea>
        <input type="number" name="total_credits" placeholder="Tổng số tín chỉ" required>
        <button type="submit">Thêm Chương trình</button>
    </form>
@endsection
