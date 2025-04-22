## Laravel Framework

Laravel là một framework PHP mạnh mẽ và phổ biến, được thiết kế để giúp phát triển ứng dụng web nhanh chóng và dễ dàng. Dưới đây là một số khái niệm và tính năng chính của Laravel:

### 1. Cài đặt Laravel
Để cài đặt Laravel, bạn cần sử dụng Composer:
```bash
composer create-project --prefer-dist laravel/laravel ten-du-an
```

### 2. Cấu trúc thư mục
Laravel có cấu trúc thư mục rõ ràng và dễ hiểu:
- **app/**: Chứa mã nguồn chính của ứng dụng.
- **routes/**: Định nghĩa các route của ứng dụng.
- **resources/**: Chứa view, file ngôn ngữ, và tài nguyên front-end.
- **config/**: Chứa các file cấu hình.

### 3. Routing
Laravel sử dụng file `routes/web.php` để định nghĩa các route:
```php
Route::get('/', function () {
    return view('welcome');
});
```

### 4. Eloquent ORM
Eloquent là ORM mạnh mẽ của Laravel, giúp làm việc với cơ sở dữ liệu dễ dàng:
```php
use App\Models\User;

$users = User::all();
```

### 5. Blade Template Engine
Blade là công cụ template mạnh mẽ của Laravel:
```blade
<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>
</head>
<body>
    <h1>{{ $title }}</h1>
</body>
</html>
```

### 6. Middleware
Middleware được sử dụng để xử lý các yêu cầu HTTP:
```php
php artisan make:middleware CheckAge
```

### 7. Artisan Command
Laravel cung cấp Artisan để thực hiện các tác vụ qua dòng lệnh:
```bash
php artisan serve
php artisan migrate
```

### 8. Tài liệu tham khảo
Để tìm hiểu thêm, hãy truy cập [Laravel Documentation](https://laravel.com/docs).

Chúc bạn học Laravel vui vẻ và hiệu quả!