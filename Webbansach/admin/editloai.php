<?php
// Bật hiển thị lỗi để debug khi trắng trang
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Kết nối CSDL
include_once('../db.php');

// Kiểm tra nếu có tham số 'id' trong URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn loại sản phẩm
    $stmt = $conn->prepare("SELECT * FROM loaisp WHERE maloai = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p>❌ Không tìm thấy loại sản phẩm với mã loại '$id'.</p>";
        exit;
    }
} else {
    echo "<p>❌ Thiếu mã loại sản phẩm trong URL. Vui lòng kiểm tra lại URL.</p>";
    exit;
}

// Xử lý khi người dùng submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_maloai = $_POST['maloai'];
    $original_maloai = $_POST['original_maloai'];
    $tenloai = $_POST['tenloai'];
    $mota = $_POST['mota'];

    if ($new_maloai !== $original_maloai) {
        $check = $conn->prepare("SELECT maloai FROM loaisp WHERE maloai = ?");
        $check->bind_param("s", $new_maloai);
        $check->execute();
        $check_result = $check->get_result();

        if ($check_result && $check_result->num_rows > 0) {
            echo "<div class='success' style='background-color:red;'>❌ Mã loại '$new_maloai' đã tồn tại. Vui lòng chọn mã khác.</div>";
            exit;
        }
    }

    $update = $conn->prepare("UPDATE loaisp SET maloai = ?, tenloai = ?, mota = ? WHERE maloai = ?");
    $update->bind_param("ssss", $new_maloai, $tenloai, $mota, $original_maloai);

    if ($update->execute()) {
        echo "<div class='success'>✅ Loại sản phẩm đã được sửa thành công! Đang chuyển hướng...</div>";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'adminhome.php';
            }, 2000);
        </script>";
        exit;
    } else {
        echo "<p style='color:red;'>❌ Lỗi khi cập nhật: " . $update->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa loại sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            width: 400px;
            margin: auto;
            margin-top: 30px;
            border: 1px solid #ccc;
            padding: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 6px;
            margin: 8px 0 16px;
        }
        .submit-btn {
            background-color: #e3431bff;
            border: none;
            padding: 10px;
            color: white;
            cursor: pointer;
            width: 100%;
        }
        .submit-btn:hover {
            background-color: #218838;
        }
        .success {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
            padding: 10px;
            background-color: #d4edda;
            border-left: 6px solid #ec3907ff;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Sửa loại sản phẩm</h2>
    <form method="post">
        <label for="maloai">Mã loại:</label>
        <input type="text" name="maloai" id="maloai" value="<?php echo htmlspecialchars($row['maloai']); ?>" required>

        <label for="tenloai">Tên loại:</label>
        <input type="text" name="tenloai" id="tenloai" value="<?php echo htmlspecialchars($row['tenloai']); ?>" required>

        <label for="mota">Mô tả:</label>
        <textarea name="mota" id="mota" rows="4"><?php echo htmlspecialchars($row['mota']); ?></textarea>

        <!-- Giữ lại mã gốc -->
        <input type="hidden" name="original_maloai" value="<?php echo htmlspecialchars($row['maloai']); ?>">

        <input type="submit" value="Cập nhật" class="submit-btn">
    </form>
</div>

</body>
</html>
