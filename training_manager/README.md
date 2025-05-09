# Training Manager

Training Manager là một ứng dụng web được xây dựng trên nền tảng Laravel, giúp quản lý các module về Sinh viên, Khóa học và Tiến độ học tập. Ứng dụng hỗ trợ các tác vụ CRUD (Tạo, Đọc, Cập nhật, Xóa) cho các module trên, đồng thời tích hợp nghiệp vụ tự động cập nhật trạng thái tiến độ (dựa trên điểm số của sinh viên) và hiển thị báo cáo qua Dashboard với các biểu đồ (sử dụng Chart.js).

## Mục lục

- [Tính năng chính](#tính-năng-chính)
- [Công nghệ sử dụng](#công-nghệ-sử-dụng)
- [Cấu trúc dự án](#cấu-trúc-dự-án)
- [Cài đặt và cấu hình](#cài-đặt-và-cấu-hình)
- [Hướng dẫn sử dụng](#hướng-dẫn-sử-dụng)
- [Nghiệp vụ và luồng xử lý](#nghiệp-vụ-và-luồng-xử-lý)
- [Các route chính](#các-route-chính)
- [Liên hệ](#liên-hệ)
- [License](#license)

## Tính năng chính

- **Quản lý Sinh viên**  
  - Tạo, hiển thị, chỉnh sửa và xóa thông tin sinh viên (tên, email, số điện thoại, ngày sinh).
  
- **Quản lý Khóa học**  
  - Quản lý thông tin khóa học, bao gồm tiêu đề, mô tả, ngày bắt đầu và ngày kết thúc.
  
- **Quản lý Tiến độ học tập**  
  - Liên kết sinh viên với khóa học thông qua bảng tiến độ.
  - Cập nhật thông tin tiến độ (điểm số, trạng thái) tự động dựa trên nghiệp vụ: nếu điểm ≥ 5, trạng thái được cập nhật là "completed", ngược lại là "pending".
  
- **Dashboard báo cáo**  
  - Trang Dashboard tích hợp các biểu đồ báo cáo (biểu đồ cột và biểu đồ tròn) sử dụng Chart.js, giúp có cái nhìn tổng quan về dữ liệu.
  
- **Quản lý thông tin người dùng (Profile)**  
  - Cho phép người dùng cập nhật thông tin cá nhân, thay đổi mật khẩu và xóa tài khoản.

## Công nghệ sử dụng

- **Back-end:** PHP 8.x, Laravel 12.x  
- **Cơ sở dữ liệu:** MySQL  
- **Front-end:** Tailwind CSS, Chart.js  
- **Quản lý phiên bản và build assets:** Composer, NPM (Vite)

## Cấu trúc dự án

```
.
├── app
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── CourseController.php
│   │   │   ├── ProgressController.php
│   │   │   ├── ProfileController.php
│   │   │   └── StudentController.php
│   │   └── ...
│   ├── Models
│   │   ├── Course.php
│   │   ├── Progress.php
│   │   └── Student.php
│   ├── Observers
│   │   └── ProgressObserver.php
│   └── Services
│       └── ProgressService.php
├── database
│   ├── migrations
│   │   ├── create_students_table.php
│   │   ├── create_courses_table.php
│   │   ├── create_progresses_table.php
│   │   └── create_course_student_table.php
│   └── seeders
├── resources
│   ├── views
│   │   ├── dashboard.blade.php
│   │   ├── layouts
│   │   │   └── app.blade.php
│   │   ├── profile
│   │   │   ├── edit.blade.php
│   │   │   └── partials
│   │   │       ├── delete-user-form.blade.php
│   │   │       ├── update-password-form.blade.php
│   │   │       └── update-profile-information-form.blade.php
│   │   ├── students
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   ├── index.blade.php
│   │   │   └── show.blade.php
│   │   ├── courses
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   ├── index.blade.php
│   │   │   └── show.blade.php
│   │   └── progresses
│   │       ├── create.blade.php
│   │       ├── edit.blade.php
│   │       ├── index.blade.php
│   │       └── show.blade.php
│   └── ...
├── routes
│   └── web.php
├── public
└── README.md
```

## Cài đặt và cấu hình

1. **Clone dự án:**

   ```bash
   git clone [repository-url]
   cd training_manager
   ```

2. **Cài đặt các PHP packages qua Composer:**

   ```bash
   composer install
   ```

3. **Cài đặt các Node packages và build front-end assets:**

   ```bash
   npm install
   npm run dev
   ```

4. **Cấu hình file .env:**

   - Sao chép file mẫu:
     ```bash
     cp .env.example .env
     ```
   - Sửa thông tin kết nối cơ sở dữ liệu:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=training_manager
     DB_USERNAME=root
     DB_PASSWORD=
     ```

5. **Chạy migrations:**

   ```bash
   php artisan migrate
   ```

6. **(Tùy chọn) Seed dữ liệu mẫu:**

   ```bash
   php artisan db:seed
   ```

7. **Chạy ứng dụng:**

   ```bash
   php artisan serve
   ```

## Hướng dẫn sử dụng

- **Dashboard quản trị:**  
  Truy cập tại `/admin/dashboard` (hoặc theo cấu trúc route đã thiết lập) để xem các biểu đồ báo cáo và tổng hợp dữ liệu.

- **Quản lý Sinh viên:**  
  Truy cập `/students` để thực hiện các thao tác quản lý thông tin sinh viên.

- **Quản lý Khóa học:**  
  Truy cập `/courses` để quản lý danh mục khóa học.

- **Quản lý Tiến độ học tập:**  
  Truy cập `/progresses` để theo dõi tiến độ của sinh viên trong từng khóa học.  
  Khi thêm mới hay cập nhật tiến độ, hệ thống sẽ tự động cập nhật trạng thái (completed/pending) dựa trên điểm số.

- **Profile cá nhân:**  
  Người dùng có thể cập nhật thông tin cá nhân tại `/admin/profile`.

## Nghiệp vụ và luồng xử lý

- **Đăng ký & Liên kết:**  
  Sinh viên được liên kết với khóa học thông qua bảng pivot và bảng tiến độ. Điều này cho phép lưu trữ thông tin tiến độ học tập cho từng sinh viên trong mỗi khóa học.

- **Tự động cập nhật tiến độ:**  
  - Khi một bản ghi tiến độ được lưu (tạo mới hoặc cập nhật), một Observer (ProgressObserver) sẽ tự động gọi ProgressService để kiểm tra điểm số.
  - Nếu `score` không null và ≥ 5, trạng thái sẽ được cập nhật là `completed`, ngược lại sẽ là `pending`.

- **Báo cáo Dashboard:**  
  Trang Dashboard tích hợp Chart.js để hiển thị biểu đồ cột và biểu đồ tròn, cung cấp số liệu trực quan về dữ liệu đăng ký và tiến độ học tập.

## Các route chính

- **Trang chủ:** `/`
- **Dashboard:**  
  `/admin/dashboard`
- **Profile:**  
  `/admin/profile`
- **Module Sinh viên:**  
  `/students`  
- **Module Khóa học:**  
  `/courses`  
- **Module Tiến độ học tập:**  
  `/progresses`

## Liên hệ

Nếu có bất kỳ thắc mắc hoặc góp ý nào, vui lòng liên hệ qua email: [email của bạn] hoặc mở issue trên repository.

## License

This project is open-sourced under the [MIT License](LICENSE).
