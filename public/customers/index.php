<?php
$pageTitle = 'Quản lý Khách hàng';

require_once '/var/www/src/config/database.php';

// Lấy thông báo lỗi xóa (nếu có từ delete.php)
$errorMessage = $_GET['error'] ?? '';

$sql = "
    SELECT 
        CustomerID,
        CustomerName,
        ContactName,
        Address,
        City,
        PostalCode,
        Country
    FROM customers
    ORDER BY CustomerID DESC";

$result = $conn->query($sql);

require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản lý Khách hàng</h2>
        <a href="create.php" class="btn btn-primary">Thêm Khách hàng</a>
    </div>

    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($errorMessage) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Người liên hệ</th>
                    <th>Địa chỉ</th>
                    <th>Thành phố</th>
                    <th>Mã bưu chính</th>
                    <th>Quốc gia</th>
                    <th width="160">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['CustomerID']) ?></td>
                            <td><?= htmlspecialchars($row['CustomerName']) ?></td>
                            <td><?= htmlspecialchars($row['ContactName'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['Address'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['City'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['PostalCode'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['Country'] ?? '') ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['CustomerID'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <form action="delete.php" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa khách hàng này?')">
                                    <input type="hidden" name="id" value="<?= $row['CustomerID'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                                </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Chưa có dữ liệu.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '/var/www/src/includes/admin/footer.php'; ?>