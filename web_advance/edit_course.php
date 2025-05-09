<?php
// Kết nối đến cơ sở dữ liệu
$conn = mysqli_connect("localhost", "root", "123456", "my_database");

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Kiểm tra nếu có ID được truyền vào
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // Truy vấn lấy thông tin môn học
    $sql = "SELECT * FROM course WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p style='color: red;'>Không tìm thấy môn học!</p>";
        exit();
    }
} else {
    echo "<p style='color: red;'>Không có ID môn học được cung cấp!</p>";
    exit();
}

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];
    $notes = $_POST['notes'];

    // Cập nhật dữ liệu vào MySQL
    $update_sql = "UPDATE course SET course_code=?, course_name=?, semester=?, ayear=?, note=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssisi", $course_code, $course_name, $semester, $academic_year, $notes, $course_id);

    if ($stmt->execute()) {
        header("Location: course_details.php?id=$course_id&update_success=1");
        exit();
    } else {
        echo "<p style='color: red;'>Lỗi khi cập nhật môn học!</p>";
    }
}

// Đóng kết nối
$stmt->close();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chỉnh sửa môn học</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "menu.php"; ?>

    <div>
        <h2>Chỉnh sửa môn học</h2>
        <form method="post" action="">
            <div>
                <label for="course_code">Mã môn học:</label>
                <input type="text" id="course_code" name="course_code" value="<?php echo $row['course_code']; ?>" required>
            </div>
            <div>
                <label for="course_name">Tên môn học:</label>
                <input type="text" id="course_name" name="course_name" value="<?php echo $row['course_name']; ?>" required>
            </div>
            <div>
                <label for="semester">Học kỳ:</label>
                <input type="text" id="semester" name="semester" value="<?php echo $row['semester']; ?>" required>
            </div>
            <div>
                <label for="academic_year">Năm học:</label>
                <input type="text" id="academic_year" name="academic_year" value="<?php echo $row['ayear']; ?>" required>
            </div>
            <div>
                <label for="notes">Ghi chú:</label>
                <textarea id="notes" name="notes"><?php echo $row['note']; ?></textarea>
            </div>
            <div>
                <button type="submit">Lưu thay đổi</button>
            </div>
        </form>
        <br>
    </div>
</body>
</html>
