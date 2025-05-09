@extends('layouts.layout')

@section('title', 'Danh sách Chương trình Đào tạo')

@section('content')
    <h2>📚 Danh sách Chương trình Đào tạo</h2>
    <a href="{{ route('programs.create') }}" class="button">➕ Thêm Chương trình</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Chương trình</th>
                <th>Mô tả</th>
                <th>Tổng tín chỉ</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($programs as $program)
                <tr>
                    <td>{{ $program->id }}</td>
                    <td>{{ $program->name }}</td>
                    <td>{{ $program->description }}</td>
                    <td>{{ $program->total_credits }}</td>
                    <td>
                        <a href="{{ route('programs.edit', $program->id) }}">✏️ Sửa</a> | 
                        <form action="{{ route('programs.destroy', $program->id) }}" method="POST" style="display:inline;">
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
