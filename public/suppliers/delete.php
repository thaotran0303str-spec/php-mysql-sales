<?php
require_once '/var/www/src/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /suppliers/'); exit; }

$supplierID = isset($_POST['id']) ? (int) $_POST['id'] : 0;
if ($supplierID <= 0) { header('Location: /suppliers/'); exit; }

$stmt = $conn->prepare("DELETE FROM suppliers WHERE SupplierID = ?");
$stmt->bind_param('i', $supplierID);

if (!$stmt->execute()) {
    $stmt->close(); $conn->close();
    header('Location: /suppliers/index.php?error=' . urlencode('Không thể xóa nhà cung cấp này do có sản phẩm liên quan!'));
    exit;
}

$stmt->close(); $conn->close();
header('Location: /suppliers/');
exit;