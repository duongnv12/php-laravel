<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h1>{{ $news->title }}</h1>
        <p class="news-description">{{ $news->description }}</p>
        <div class="news-content">
            <p>{{ $news->content }}</p>
        </div>

        <a href="/news/list" class="btn back">Quay lại danh sách tin tức</a>
    </div>
</body>
</html>
