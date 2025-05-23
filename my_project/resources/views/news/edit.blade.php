<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa tin tức</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h1>Chỉnh sửa tin tức</h1>

        <form action="/news/update/{{ $news->id }}" method="POST">
            @csrf
            @method('POST')

            <label for="title">Tiêu đề:</label>
            <input type="text" id="title" name="title" value="{{ $news->title }}" required>

            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" required>{{ $news->description }}</textarea>

            <label for="content">Nội dung:</label>
            <textarea id="content" name="content" required>{{ $news->content }}</textarea>

            <button type="submit" class="btn update">Cập nhật tin tức</button>
        </form>

        <a href="/news/list" class="btn back">Quay lại danh sách tin tức</a>
    </div>
</body>
</html>
