<!DOCTYPE html>
<html>
<head>
    <title>Chi tiết môn học</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "menu.php"; ?>

    <div>
        <h2>Chi tiết môn học</h2>

        <?php
        // Kiểm tra nếu có ID được truyền vào
        if (isset($_GET['id'])) {
            $course_id = $_GET['id'];

            // Kết nối đến cơ sở dữ liệu
            $conn = mysqli_connect("localhost", "root", "123456", "my_database");

            // Kiểm tra kết nối
            if (!$conn) {
                die("Kết nối thất bại: " . mysqli_connect_error());
            }

            // Truy vấn lấy thông tin môn học
            $sql = "SELECT * FROM course WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $course_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<p><strong>Mã học phần:</strong> " . $row["course_code"] . "</p>";
                echo "<p><strong>Tên học phần:</strong> " . $row["course_name"] . "</p>";
                echo "<p><strong>Học kỳ:</strong> " . $row["semester"] . "</p>";
                echo "<p><strong>Năm học:</strong> " . $row["ayear"] . "</p>";
                echo "<p><strong>Ghi chú:</strong> " . $row["note"] . "</p>";

                // Nút "Sửa" và "Xóa"
                echo "<a href='edit_course.php?id=" . $row["id"] . "' class='btn btn-edit'>Sửa</a> ";
                echo "<a href='delete_course.php?id=" . $row["id"] . "' class='btn btn-delete' onclick='return confirm(\"Bạn có chắc chắn muốn xóa môn học này?\");'>Xóa</a>";

            } else {
                echo "<p style='color: red;'>Không tìm thấy môn học!</p>";
            }

            // Đóng kết nối
            $stmt->close();
            mysqli_close($conn);
        } else {
            echo "<p style='color: red;'>Không có ID môn học được cung cấp!</p>";
        }
        ?>
    </div>
</body>
</html>
