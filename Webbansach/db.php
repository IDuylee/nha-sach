<?php
$servername = "localhost";
$username = "root"; // Tên đăng nhập MySQL
$password = ""; // Mật khẩu MySQL (thường là rỗng nếu dùng XAMPP)
$dbname = "nhasach"; // Tên cơ sở dữ liệu

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
