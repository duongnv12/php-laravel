<!DOCTYPE html>
<html>
<head>
    <title>Danh sách môn học</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "menu.php"; ?>
    <div>
        <h2>Danh sách môn học</h2>
        <table class="course-table" border="1">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã học phần</th>
                    <th>Tên học phần</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Kết nối đến cơ sở dữ liệu
                $conn = mysqli_connect("localhost", "root", "123456", "my_database");

                // Kiểm tra kết nối
                if (!$conn) {
                    die("Kết nối thất bại: " . mysqli_connect_error());
                }

                // Truy vấn lấy danh sách môn học
                $sql = "SELECT id, course_code, course_name FROM course ORDER BY id DESC";
                $result = mysqli_query($conn, $sql);
                $stt = 1;

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) :
                        ?>
                        <tr>
                            <td><?php echo $stt; ?></td>
                            <td><?php echo $row["course_code"]; ?></td>
                            <td><?php echo $row["course_name"]; ?></td>
                            <td>
                                <a href="course_details.php?id=<?php echo $row['id']; ?>">Xem chi tiết</a>
                            </td>
                        </tr>
                        <?php
                        $stt++;
                    endwhile;
                } else {
                    echo "<tr><td colspan='4'>Không có môn học nào</td></tr>";
                }

                // Đóng kết nối
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
