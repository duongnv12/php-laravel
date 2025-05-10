# Training Manager

Training Manager là một ứng dụng web được xây dựng trên nền tảng Laravel, hỗ trợ quản lý các module về Sinh viên, Môn học, Chương trình đào tạo, Niên khóa, Đăng ký học (Enrollment) và Theo dõi tiến độ học tập. Ứng dụng tích hợp nghiệp vụ tự động cập nhật trạng thái tiến độ học tập (dựa trên điểm số của sinh viên) và trình bày báo cáo thông qua Dashboard với các biểu đồ tương tác sử dụng Chart.js.

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

- **Quản lý Sinh viên:**  
  - Tạo, hiển thị, chỉnh sửa và xóa thông tin của sinh viên (tên, email, số điện thoại, ngày sinh,...).

- **Quản lý Môn học:**  
  - Quản lý thông tin các môn học, bao gồm mã môn, tên, mô tả, số tín chỉ,…  
  - Hỗ trợ liên kết các môn tiên quyết (nếu có).

- **Quản lý Đăng ký học (Enrollment):**  
  - Liên kết sinh viên với các môn học; lưu trữ thông tin về trạng thái đăng ký (registered, completed, failed) và điểm số.
  - Cho phép giảng viên hoặc admin cập nhật tiến độ học tập của sinh viên trên từng môn học.

- **Quản lý Tiến độ học tập:**  
  - Tự động cập nhật trạng thái của tiến độ học tập (completed/pending) dựa trên điểm số, thông qua Observer và Service.
  
- **Dashboard báo cáo:**  
  - Trang dashboard hiển thị các số liệu thống kê như tổng số đăng ký, số đăng ký hoàn thành, tỷ lệ hoàn thành,...
  - Tích hợp nhiều loại biểu đồ (Bar Chart, Pie Chart, Line Chart, Doughnut Chart) sử dụng Chart.js để báo cáo trực quan.

- **Quản lý thông tin người dùng (Profile):**  
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
│   │   │   ├── EnrollmentController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ProgressController.php
│   │   │   ├── ProfileController.php
│   │   │   └── StudentController.php
│   │   └── ...
│   ├── Models
│   │   ├── Course.php
│   │   ├── Enrollment.php
│   │   ├── Progress.php
│   │   └── Student.php
│   └── ...
├── database
│   ├── migrations
│   │   ├── create_students_table.php
│   │   ├── create_courses_table.php
│   │   ├── create_enrollments_table.php
│   │   ├── create_progresses_table.php
│   │   └── ... (các bảng khác như programs, cohorts)
│   └── seeders
├── resources
│   ├── views
│   │   ├── dashboard
│   │   │   └── index.blade.php
│   │   ├── layouts
│   │   │   └── app.blade.php
│   │   ├── profile
│   │   │   └── ... (các file profile)
│   │   ├── students
│   │   │   └── ... (CRUD views)
│   │   ├── courses
│   │   │   └── ... (CRUD views)
│   │   ├── progresses
│   │   │   └── ... (CRUD views)
│   │   └── enrollments
│   │       └── ... (CRUD views)
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
  Truy cập `/dashboard` để xem các số liệu thống kê và biểu đồ báo cáo (Bar, Pie, Line, Doughnut) được tích hợp qua Chart.js.

- **Quản lý Sinh viên:**  
  Truy cập `/students` để thực hiện các thao tác quản lý dữ liệu sinh viên.

- **Quản lý Môn học:**  
  Truy cập `/courses` để quản lý thông tin các môn học.

- **Quản lý Đăng ký học (Enrollment):**  
  Truy cập `/enrollments` để đăng ký môn học của sinh viên và theo dõi tiến độ học tập từng môn.

- **Quản lý Tiến độ học tập:**  
  Truy cập `/progresses` để theo dõi và cập nhật kết quả học tập của sinh viên (tự động chuyển trạng thái dựa trên điểm số).

- **Profile cá nhân:**  
  Cập nhật thông tin cá nhân tại `/profile`.

## Nghiệp vụ và luồng xử lý

- **Đăng ký & Liên kết:**  
  Sinh viên được liên kết với môn học qua bảng Enrollment, cho phép lưu trữ thông tin tiến độ cùng với điểm số và trạng thái (registered/completed/failed).

- **Tự động cập nhật tiến độ:**  
  Khi tiến độ học tập được lưu (tạo mới hoặc cập nhật), Observer và ProgressService tự động kiểm tra điểm số và cập nhật trạng thái tương ứng (completed khi điểm ≥ 5, ngược lại là pending).

- **Báo cáo Dashboard:**  
  Dashboard tổng hợp thống kê số liệu và hiển thị qua các biểu đồ tùy chỉnh (sử dụng Chart.js), giúp ban quản trị và giảng viên có cái nhìn tổng quan về dữ liệu đào tạo.

## Các route chính

- **Trang chủ:** `/`
- **Dashboard:** `/dashboard`
- **Profile:** `/profile`
- **Module Sinh viên:** `/students`
- **Module Môn học:** `/courses`
- **Module Đăng ký học (Enrollment):** `/enrollments`
- **Module Tiến độ học tập:** `/progresses`

## Liên hệ

Nếu có bất kỳ thắc mắc hoặc góp ý nào, vui lòng liên hệ qua email: [email của bạn] hoặc mở issue trên repository.

## License

This project is open-sourced under the [MIT License](LICENSE).