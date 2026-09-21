<?php
$pageTitle = 'Thêm Nhân viên giao hàng';

require_once '/var/www/src/config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shipperName = trim($_POST['ShipperName'] ?? '');
    $phone = trim($_POST['Phone'] ?? '');

    if (!empty($shipperName)) {
        $sql = "INSERT INTO shippers (ShipperName, Phone) VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('ss', $shipperName, $phone);

            if ($stmt->execute()) {
                $stmt->close();
                header('Location: index.php');
                exit;
            } else {
                $error = 'Không thể thêm nhân viên giao hàng vào cơ sở dữ liệu.';
            }
            $stmt->close();
        } else {
            $error = 'Lỗi câu lệnh cơ sở dữ liệu!';
        }
    } else {
        $error = 'Vui lòng nhập tên nhân viên giao hàng!';
    }
}

require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Thêm Nhân Viên Giao Hàng Mới</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="create.php" method="POST">
                <div class="mb-3">
                    <label for="ShipperName" class="form-label font-weight-bold">
                        Tên nhân viên giao hàng <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="ShipperName" 
                           name="ShipperName" 
                           placeholder="Ví dụ: Nguyễn Văn A, Giao Hàng Nhanh..." 
                           required>
                </div>

                <div class="mb-3">
                    <label for="Phone" class="form-label font-weight-bold">Số điện thoại</label>
                    <input type="text" 
                           class="form-control" 
                           id="Phone" 
                           name="Phone" 
                           placeholder="Ví dụ: 0901234567">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Lưu lại</button>
                    <a href="index.php" class="btn btn-secondary">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '/var/www/src/includes/admin/footer.php'; ?>