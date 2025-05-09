<?php
$servername = "localhost";
$username = "root";
$password = "123456"; 

// Kết nối MySQL
$conn = new mysqli($servername, $username, $password);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Tạo cơ sở dữ liệu
$sql = "CREATE DATABASE my_database";
if ($conn->query($sql) === TRUE) {
    echo "Cơ sở dữ liệu đã được tạo thành công";
} else {
    echo "Lỗi khi tạo cơ sở dữ liệu: " . $conn->error;
}

$conn->close();
?>
