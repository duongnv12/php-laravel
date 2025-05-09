<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối đến cơ sở dữ liệu
    $conn = mysqli_connect("localhost", "root", "123456", "my_database");

    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }

    // Lấy dữ liệu từ form
    $course_code = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $semester = $_POST['semester'];
    $academic_year = $_POST['academic_year'];
    $notes = $_POST['notes'];

    // Thực thi truy vấn
    $sql = "INSERT INTO course (course_code, course_name, ayear, semester, note) 
            VALUES ('$course_code', '$course_name', '$academic_year', '$semester', '$notes')";

    if (mysqli_query($conn, $sql)) {
        // Redirect về `add_course.php` với thông báo thành công
        header("Location: add_course.php?success=1");
        // Đóng kết nối
        mysqli_close($conn);
        exit();
    } else {
        // Đóng kết nối
        mysqli_close($conn);
        // Redirect về `add_course.php` với thông báo lỗi
        header("Location: add_course.php?error=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    // Nếu truy cập trực tiếp `process_add_course.php`, quay về `add_course.php`
    header("Location: add_course.php");
    exit();
}
