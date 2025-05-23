<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tin Tức</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h1>Thêm Tin Tức</h1>
        <form action="/news/store" method="POST">
            @csrf
            <label for="title">Tiêu đề:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="content">Nội dung:</label>
            <textarea id="content" name="content" required></textarea>

            <button type="submit">Thêm Tin Tức</button>
        </form>
    </div>
</body>
</html>
