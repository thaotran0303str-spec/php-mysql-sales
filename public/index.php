<?php
$host = 'db';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>Hệ thống quản lý bán hàng</h1>";
    echo "<p style='color: green; font-weight: bold;'>🎉 Kết nối cơ sở dữ liệu MySQL thành công!</p>";
} catch (PDOException $e) {
    echo "<h1>Hệ thống quản lý bán hàng</h1>";
    echo "<p style='color: red; font-weight: bold;'>❌ Kết nối thất bại: " . $e->getMessage() . "</p>";
}
?>