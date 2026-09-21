<?php

$pageTitle = 'Quản lý sản phẩm';

// 1. Kết nối Cơ sở dữ liệu (Gọi file database.php cùng thư mục)
require_once __DIR__ . '/database.php';

// 2. Truy vấn danh sách sản phẩm kết hợp danh mục và nhà cung cấp
$sql = "
    SELECT 
        p.ProductID,
        p.ProductCode,
        p.ProductName,
        p.Unit,
        p.Price,
        p.StockQuantity,
        p.IsActive,
        c.CategoryName,
        s.SupplierName
    FROM products p
    LEFT JOIN categories c ON p.CategoryID = c.CategoryID
    LEFT JOIN suppliers s ON p.SupplierID = s.SupplierID
    ORDER BY p.ProductID DESC
";
$result = $conn->query($sql);

// 3. Import giao diện Header & Navbar
require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';

?>



    <!-- Tiêu đề & Nút thêm mới -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản lý sản phẩm</h2>
        <a href="/admin/products/create.php" class="btn btn-primary">
            + Thêm sản phẩm
        </a>
    </div>

    <!-- Bảng hiển thị danh sách sản phẩm -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th style="width: 90px;">Hình ảnh</th>
                    <th>Mã SP</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Nhà cung cấp</th>
                    <th>Đơn vị</th>
                    <th>Giá bán</th>
                    <th>Tồn kho</th>
                    <th>Trạng thái</th>
                    <th style="width: 130px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <tr>
                        <!-- 1. Cột Hình ảnh -->
                        <td class="text-center">
                            <?php if (!empty($product['ImagePath'])): ?>
                                <img src="/<?= ltrim(htmlspecialchars($product['ImagePath']), '/') ?>" 
                                     alt="<?= htmlspecialchars($product['ProductName']) ?>" 
                                     class="img-thumbnail" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            <?php else: ?>
                                <span class="badge bg-light text-secondary border">Không ảnh</span>
                            <?php endif; ?>
                        </td>

                        <!-- 2. Thông tin chi tiết sản phẩm --><td class="fw-bold text-center"><?= htmlspecialchars($product['ProductCode']) ?></td>
                        <td><?= htmlspecialchars($product['ProductName']) ?></td>
                        <td><?= htmlspecialchars($product['CategoryName'] ?? 'Chưa phân loại') ?></td>
                        <td><?= htmlspecialchars($product['SupplierName'] ?? 'Chưa có NCC') ?></td>
                        <td class="text-center"><?= htmlspecialchars($product['Unit'] ?? '-') ?></td>
                        <td class="text-end fw-bold text-primary">
                            <?= number_format((float)$product['Price'], 0, ',', '.') ?> đ
                        </td>
                        <td class="text-end"><?= (int)$product['StockQuantity'] ?></td>
                        
                        <!-- 3. Trạng thái -->
                        <td class="text-center">
                            <?php if ((int)$product['IsActive'] === 1): ?>
                                <span class="badge bg-success">Đang bán</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Ngừng bán</span>
                            <?php endif; ?>
                        </td>

                        <!-- 4. Cột Thao tác (Chỉ giữ duy nhất 1 nút Sửa và 1 nút Xóa) -->
                        <td class="text-center">
                            <a href="/admin/products/edit.php?id=<?= $product['ProductID'] ?>" 
                               class="btn btn-sm btn-warning">Sửa</a>
                            
                            <a href="/admin/products/delete.php?id=<?= $product['ProductID'] ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm <?= htmlspecialchars($product['ProductName']) ?>?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center text-muted">Chưa có dữ liệu sản phẩm.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php
// 4. Import Footer & Đóng kết nối CSDL
require_once __DIR__ . '/footer.php';
$conn->close();
?>