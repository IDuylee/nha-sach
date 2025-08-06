<?php
include_once('../db.php');

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maloai = trim($_POST['maloai']);
    $tenloai = trim($_POST['tenloai']);
    $mota = trim($_POST['mota']);

    // Kiểm tra trùng mã loại
    $check_stmt = $conn->prepare("SELECT COUNT(*) FROM loaisp WHERE maloai = ?");
    $check_stmt->bind_param("s", $maloai);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($count > 0) {
        $error_message = "❌ Mã loại '$maloai' đã tồn tại. Vui lòng chọn mã khác.";
    } else {
        // Thêm dữ liệu nếu không bị trùng
        $stmt = $conn->prepare("INSERT INTO loaisp (maloai, tenloai, mota) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $maloai, $tenloai, $mota);

        if ($stmt->execute()) {
            $success_message = "✅ Thêm loại sản phẩm thành công! Đang chuyển hướng...";
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'adminhome.php';
                }, 2000);
            </script>";
        } else {
            $error_message = "❌ Lỗi khi thêm: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Loại Sản Phẩm</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
        }

        h2 {
            background-color: #770000;
            color: white;
            text-align: center;
            padding: 15px;
            margin: 0;
            border-radius: 5px 5px 0 0;
        }

        .right {
            margin-left: 25%;
            width: 70%;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #770000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            width: 48%;
            text-align: center;
            box-sizing: border-box;
        }

        .button:hover {
            background-color: #990000;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], textarea {
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #770000;
            color: white;
            border: none;
            padding: 10px;
            font-weight: bold;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #990000;
        }

        .error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        .success {
            color: green;
            font-weight: bold;
            margin-top: 10px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .back-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="right">
    <h2>Thêm Loại Sản Phẩm</h2>
    <form action="insertloai.php" method="POST">
        <label for="maloai">Mã Loại:</label>
        <input type="text" name="maloai" required>

        <label for="tenloai">Tên Loại:</label>
        <input type="text" name="tenloai" required>

        <label for="mota">Mô Tả:</label>
        <textarea name="mota" rows="4" required></textarea>

        <div class="button-container">
            <input type="submit" value="Thêm Loại" class="button">
            <a href="adminhome.php" class="button">Quay lại</a>
        </div>
    </form>

    <?php if (!empty($success_message)): ?>
        <p class="success"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>
</div>
</body>
</html>
