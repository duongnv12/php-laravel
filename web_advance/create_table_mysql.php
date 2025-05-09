<?php
$servername = "localhost";
$username = "root";
$password = "123456"; // Thay bằng mật khẩu MySQL của bạn
$database = "my_database"; // Thay bằng tên cơ sở dữ liệu của bạn

// Kết nối MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xóa bảng nếu đã tồn tại (tùy chọn)
$sql = "DROP TABLE IF EXISTS course";
$conn->query($sql);

// Tạo bảng course với cột semester
$sql = "CREATE TABLE course (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(50) NOT NULL,
    course_name VARCHAR(255) NOT NULL,
    ayear YEAR NOT NULL,
    semester VARCHAR(20) NOT NULL,
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Bảng 'course' đã được tạo thành công với cột 'semester'";
} else {
    echo "Lỗi khi tạo bảng: " . $conn->error;
}

$conn->close();
?>
