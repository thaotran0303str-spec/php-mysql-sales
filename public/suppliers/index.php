<?php
$pageTitle = 'Quản lý Nhà cung cấp';
require_once '/var/www/src/config/database.php';

$errorMessage = $_GET['error'] ?? '';
$sql = "SELECT SupplierID, SupplierName, ContactName, Address, City, PostalCode, Country, Phone FROM suppliers ORDER BY SupplierID DESC";
$result = $conn->query($sql);

require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản lý Nhà cung cấp</h2>
        <a href="create.php" class="btn btn-primary">Thêm Nhà cung cấp</a>
    </div>

    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($errorMessage) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên nhà cung cấp</th>
                    <th>Người liên hệ</th>
                    <th>Địa chỉ</th>
                    <th>Thành phố</th>
                    <th>Quốc gia</th>
                    <th>Điện thoại</th>
                    <th width="160">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['SupplierID']) ?></td>
                            <td><?= htmlspecialchars($row['SupplierName']) ?></td>
                            <td><?= htmlspecialchars($row['ContactName'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['Address'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['City'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['Country'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['Phone'] ?? '') ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['SupplierID'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <form action="delete.php" method="POST" class="d-inline" onsubmit="return confirm('Xóa nhà cung cấp này?')">
                                    <input type="hidden" name="id" value="<?= $row['SupplierID'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?><tr><td colspan="8" class="text-center">Chưa có dữ liệu.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '/var/www/src/includes/admin/footer.php'; ?>