<?php
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // Kết nối đến cơ sở dữ liệu
    $conn = mysqli_connect("localhost", "root", "123456", "my_database");

    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }

    // Xóa môn học
    $sql = "DELETE FROM course WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);

    if ($stmt->execute()) {
        // Chuyển hướng về `index.php` sau khi xóa
        header("Location: index.php?delete_success=1");
        exit();
    } else {
        echo "<p style='color: red;'>Lỗi khi xóa môn học!</p>";
    }

    // Đóng kết nối
    $stmt->close();
    mysqli_close($conn);
} else {
    echo "<p style='color: red;'>Không có ID môn học được cung cấp!</p>";
}
?>
