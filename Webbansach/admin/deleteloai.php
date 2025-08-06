<?php
include_once('../db.php');

$error_message = '';
$success_message = '';
$row = null;

// Kiểm tra nếu có tham số 'id' trong URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn thông tin loại sản phẩm theo 'maloai' (dùng prepared statement)
    $stmt = $conn->prepare("SELECT * FROM loaisp WHERE maloai = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra nếu có kết quả
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $error_message = "❌ Không tìm thấy loại sản phẩm với mã loại '$id'.";
    }

    // Xử lý xóa khi người dùng nhấn nút Xóa
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
        $stmt_delete = $conn->prepare("DELETE FROM loaisp WHERE maloai = ?");
        $stmt_delete->bind_param("s", $id);

        if ($stmt_delete->execute()) {
            $success_message = "✅ Xóa loại sản phẩm thành công! Đang chuyển hướng...";
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'adminhome.php'; // Chuyển hướng sau 2 giây
                }, 2000);
            </script>";
        } else {
            $error_message = "❌ Lỗi xóa: " . $stmt_delete->error;
        }
    }
} else {
    $error_message = "❌ Thiếu mã loại sản phẩm trong URL. Vui lòng kiểm tra lại.";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xóa Loại Sản Phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            padding: 0; margin: 0;
        }

        .right {
            margin-left: 25%;
            width: 70%;
            background-color: #fff;
            padding: 20px;
            margin-top: 30px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        h2 {
            background-color: #770000;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 5px 5px 0 0;
        }

        .button {
            background-color: #770000;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .button:hover {
            background-color: #990000;
        }

        .button-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .info {
            margin: 10px 0;
            font-size: 16px;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .success {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="right">
    <h2>Xóa Loại Sản Phẩm</h2>

    <?php if ($error_message): ?>
        <p class="error"><?= $error_message ?></p>
    <?php elseif ($success_message): ?>
        <p class="success"><?= $success_message ?></p>
    <?php elseif ($row): ?>
        <div class="info"><strong>Mã Loại:</strong> <?= htmlspecialchars($row['maloai']) ?></div>
        <div class="info"><strong>Tên Loại:</strong> <?= htmlspecialchars($row['tenloai']) ?></div>
        <div class="info"><strong>Mô Tả:</strong> <?= htmlspecialchars($row['mota']) ?></div>

        <p>Bạn có chắc chắn muốn xóa loại sản phẩm này?</p>

        <form action="deleteloai.php?id=<?= urlencode($id) ?>" method="POST">
            <div class="button-container">
                <input type="submit" name="delete" value="Xóa" class="button">
                <a href="adminhome.php" class="button">Quay lại</a>
            </div>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
