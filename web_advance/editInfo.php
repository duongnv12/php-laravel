<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $name = $_SESSION['name'] ?? "Nguyễn Văn Dương";
    $class = $_SESSION['class'] ?? "K16-CNTT3";
    $studentID = $_SESSION['studentID'] ?? "22010019";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chỉnh sửa thông tin</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <?php include"menu.php"; ?>

    <div>
        <h2>Chỉnh sửa thông tin cá nhân</h2>
        <form method="post" action="process_edit_info.php">
            <div>
                <label for="name">Tên:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div>
                <label for="class">Lớp:</label>
                <input type="text" id="class" name="class" value="<?php echo htmlspecialchars($class); ?>">
            </div>
            <div>
                <label for="studentID">Mã sinh viên:</label>
                <input type="text" id="studentID" name="studentID" value="<?php echo htmlspecialchars($studentID); ?>" required>
            </div>
            <button type="submit">Lưu thay đổi</button>
        </form>
    </div>

</body>
</html>