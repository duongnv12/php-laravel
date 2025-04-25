<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['name'])) {
        $_SESSION['name'] = "Nguyễn Văn Dương"; 
    }
    if (!isset($_SESSION['class'])) {
        $_SESSION['class'] = "K16-CNTT3";   
    }
    if (!isset($_SESSION['studentID'])) {
        $_SESSION['studentID'] = "22010019";
    }

    $name = $_SESSION['name'];
    $class = $_SESSION['class'];
    $studentID = $_SESSION['studentID'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang chủ</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <?php include('menu.php'); ?>

    <div class="info">
        <h2>Thông tin cá nhân</h2>
        <p><strong>Tên:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Lớp:</strong> <?php echo htmlspecialchars($class); ?></p>
        <p><strong>Mã sinh viên:</strong> <?php echo htmlspecialchars($studentID); ?></p>
    </div>

</body>
</html>