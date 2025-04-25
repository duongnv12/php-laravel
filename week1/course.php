<!DOCTYPE html>
<html>
<head>
    <title>Trang chủ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "menu.php"; ?>
    <div>
        <h2>Danh sách môn học</h2>
        <table class="course-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã học phần</th>
                    <th>Tên học phần</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $courses = [
                        'CSE702051' => 'Thiết kế web nâng cao',
                    ];

                    $stt = 1; 

                    foreach ($courses as $id => $name) :
                        ?>
                    <tr>
                        <td><?php echo $stt; ?></td>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $name; ?></td>
                    </tr>
                <?php
                    $stt++;
                    endforeach;
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>