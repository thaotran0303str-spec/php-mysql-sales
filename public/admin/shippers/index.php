<?php
$pageTitle = 'Quản lý Nhân viên giao hàng';

require_once '/var/www/src/config/database.php';

// Lấy thông báo lỗi xóa (nếu có từ delete.php)
$errorMessage = $_GET['error'] ?? '';

$sql = "
    SELECT 
        ShipperID,
        ShipperName,
        Phone
    FROM shippers
    ORDER BY ShipperID DESC
";

$result = $conn->query($sql);

require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản lý Nhân viên giao hàng</h2>
        <a href="create.php" class="btn btn-primary">Thêm Nhân viên giao hàng</a>
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
                    <th>Tên nhân viên giao hàng</th>
                    <th>Số điện thoại</th>
                    <th width="160">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['ShipperID']) ?></td>
                            <td><?= htmlspecialchars($row['ShipperName']) ?></td>
                            <td><?= htmlspecialchars($row['Phone'] ?? '') ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['ShipperID'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <form action="delete.php" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa nhân viên giao hàng này?')">
    <input type="hidden" name="id" value="<?= $row['ShipperID'] ?>">
    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
</form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Chưa có dữ liệu.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '/var/www/src/includes/admin/footer.php'; ?>