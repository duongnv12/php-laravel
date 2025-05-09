<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Thêm môn học</title>
</head>
<body>
    <?php include("menu.php"); ?>

    <div>
        <h2>Thêm môn học mới</h2>

        <?php
        // Hiển thị thông báo nếu có
        if (isset($_GET['success'])) {
            echo "<p style='color: green;'>Thêm môn học thành công!</p>";
        } elseif (isset($_GET['error'])) {
            echo "<p style='color: red;'>Lỗi: " . $_GET['error'] . "</p>";
        }
        ?>

        <form method="post" action="process_add_course.php">
            <div>
                <label for="course_id">Mã môn học:</label>
                <input type="text" id="course_id" name="course_id" required>
            </div>
            <div>
                <label for="course_name">Tên môn học:</label>
                <input type="text" id="course_name" name="course_name" required>
            </div>
            <div>
                <label for="semester">Học kỳ:</label>
                <input type="text" id="semester" name="semester" required>
            </div>
            <div>
                <label for="academic_year">Năm học:</label>
                <input type="text" id="academic_year" name="academic_year" required>
            </div>
            <div>
                <label for="notes">Ghi chú:</label>
                <textarea id="notes" name="notes"></textarea>
            </div>
            <div>
                <button type="submit">Thêm môn học</button>
            </div>
        </form>
    </div>
</body>
</html>
