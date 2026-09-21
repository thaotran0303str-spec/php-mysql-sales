<?php

// Bạn đổi 'localhost' thành 'db' (nếu dùng Docker Compose) hoặc '127.0.0.1'
$host     = 'db';            // Thử đổi thành 'db' hoặc 'mysql' hoặc '127.0.0.1'
$username = 'root';          // Tên tài khoản database
$password = 'root';          // Mật khẩu database
$dbname   = 'ql_banhang';    // Tên database
$port     = 3306;

// Khởi tạo kết nối
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Kiểm tra lỗi kết nối
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Thiết lập bảng mã tiếng Việt
$conn->set_charset("utf8mb4");