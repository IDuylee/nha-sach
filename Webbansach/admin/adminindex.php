<?php
include_once('../db.php');
session_start();

$error_message = ''; // Khởi tạo biến thông báo lỗi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['txtName']; // lấy dữ liệu username
    $pass = $_POST['txtPass']; // lấy dữ liệu pass

    // Truy vấn cơ sở dữ liệu để kiểm tra tài khoản và mật khẩu
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra kết quả đăng nhập
    if ($result->num_rows > 0) { // đăng nhập thành công
        $_SESSION['user'] = $user; // Lưu thông tin tên đăng nhập vào session
        header("Location: adminhome.php"); // Chuyển hướng về trang quản lý
    } else {
        $error_message = "❌ Tài khoản hoặc mật khẩu sai!"; // Thông báo lỗi nếu đăng nhập thất bại
    }

    $stmt->close();
    $conn->close(); // Đóng kết nối
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        form {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 350px;
            padding: 30px 20px;
            text-align: center;
        }

        form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        form div {
            margin-bottom: 15px;
            text-align: left;
        }

        form label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
            color: #555;
        }

        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        form input[type="text"]:focus,
        form input[type="password"]:focus {
            border-color: #770000;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }

        form input[type="submit"],
        form input[type="reset"] {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            font-weight: bold;
            color: #fff;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        form input[type="submit"] {
            background-color: #770000;
        }

        form input[type="reset"] {
            background-color: #770000;
        }

        form .button-group {
            display: flex;
            justify-content: space-between;
        }

        form p {
            font-size: 12px;
            margin-top: 20px;
            color: #888;
        }

        .error-message {
            color: red;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            text-align: center; /* Căn giữa thông báo lỗi */
        }
    </style>
</head>
<body>
    <form action="adminindex.php" method="POST">
        <h2>ĐĂNG NHẬP</h2>

        <div>
            <label for="txtName">Tài khoản</label>
            <input type="text" name="txtName" id="txtName" placeholder="Nhập tài khoản của bạn">
        </div>
        <div>
            <label for="txtPass">Mật khẩu</label>
            <input type="password" name="txtPass" id="txtPass" placeholder="Nhập mật khẩu của bạn">
        </div>
        <div class="button-group">
            <input type="submit" value="Đăng nhập">
            <input type="reset" value="Hủy">
        </div>

        <!-- Hiển thị thông báo lỗi dưới cùng -->
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <p>Bạn quên mật khẩu? Liên hệ hỗ trợ.</p>
    </form>
</body>
</html>
