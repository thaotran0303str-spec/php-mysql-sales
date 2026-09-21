<?php
// 1. Kết nối cơ sở dữ liệu
require_once __DIR__ . '/database.php';

// 2. Lấy ID sản phẩm cần xóa từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // 3. Thực hiện xóa trực tiếp sản phẩm trong bảng products
    $stmt = $conn->prepare("DELETE FROM products WHERE ProductID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// 4. Chuyển hướng quay về lại trang danh sách sản phẩm
header("Location: /admin/products/index.php");
exit;