<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách tin tức</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h1>Danh sách Tin Tức</h1>

        @if(session('success'))
            <p class="success-message">{{ session('success') }}</p>
        @endif

        <a href="/news/add" class="add-button">Thêm Tin Tức</a>

        @foreach($newsList as $news)
            <div class="news-item">
                <h2>{{ $news->title }}</h2>
                <p>{{ $news->description }}</p>
                <a href="/news/show/{{ $news->id }}" class="btn">Xem chi tiết</a>
                <a href="/news/edit/{{ $news->id }}" class="btn edit">Chỉnh sửa</a>
                <form action="/news/delete/{{ $news->id }}" method="POST" onsubmit="return confirmDelete()" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn delete">Xóa</button>
                </form>
            </div>
        @endforeach
    </div>
    <script>
        function confirmDelete() {
            return confirm("Bạn có chắc chắn muốn xóa tin tức này?");
        }
    </script>
</body>
</html>
