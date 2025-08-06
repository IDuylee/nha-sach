<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang admin</title>
    <style>
        /* Body styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
            color: #333;
        }

        /* Header styling */
        h2 {
            background-color: #770000;
            color: white;
            text-align: center;
            padding: 15px;
            margin: 0;
            border-radius: 5px 5px 0 0;
        }

        /* Container styling */
        div {
            padding: 10px;
        }

        /* Sidebar (Left) styling */
        .left {
            float: left;
            width: 25%;
            background-color: #fff;
            border-right: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 5px;
            margin-right: 10px;
        }

        .left ul {
            list-style: none;
            padding: 0;
        }

        .left li {
            margin-bottom: 10px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9fafb;
            border: 1px solid #ddd;
            font-weight: bold;
        }

        .left li a {
            text-decoration: none;
            color: black;
            font-size: 14px;
        }

        .left li:hover {
            color: black;
            cursor: pointer;
        }

        .left li:hover a {
            color: black;
        }

        /* Main content (Right) styling */
        .right {
            float: left;
            width: 70%;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: left;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table th {
            background-color: #770000;
            color: white;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        table tr:hover {
            background-color: #f1f5f9;
        }

        table a {
            color: #770000;
            text-decoration: none;
            font-weight: bold;
        }

        table a:hover {
            text-decoration: underline;
        }

        /* Add button styling */
        .right a.button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #770000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .right a.button:hover {
            background-color: #990000;
        }
    </style>
</head>
<?php
    include_once('../db.php');
    session_start();
?>
<body>
<div>
    <h2>Trang quản lý bán hàng</h2>
</div>

<div>
    <div class="left">
        <ul>
            <li style="text-align: center; font-weight: bold;">Danh mục</li>
            <li>
                <a href="adminhome.php">Quản lý danh mục sản phẩm</a>
            </li>
            <li>
                <a href="adminproduct.php">Quản lý sản phẩm</a>
            </li>
        </ul>
    </div>
    <div class="right">
        <h2>Danh mục sản phẩm</h2>
        <a href="insertloai.php" class="button">Thêm loại sản phẩm</a>
        <?php
            $sql = "SELECT * FROM loaisp"; // Lấy tất cả loại sản phẩm
            $result = $conn->query($sql); // Thực hiện câu truy vấn
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Mã loại</th><th>Tên loại</th><th>Sửa</th><th>Xóa</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['maloai'] . "</td>";
                    echo "<td>" . $row['tenloai'] . "</td>";
                    echo "<td><a href='editloai.php?id=" . $row['maloai'] . "&type=e'>Sửa</a></td>";
                    echo "<td><a href='deleteloai.php?id=" . $row['maloai'] . "&type=d'>Xóa</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else { 
                echo "<p>Không có dữ liệu, hãy thêm mới loại sản phẩm!</p>";
            }
        ?>
    </div>
</div>
</body>
</html>
