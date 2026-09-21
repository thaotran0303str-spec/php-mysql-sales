<?php
$pageTitle = 'Cập Nhật Nhân viên giao hàng';

require_once '/var/www/src/config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

$error = '';

// Lấy thông tin hiện tại
$stmt = $conn->prepare("SELECT ShipperID, ShipperName, Phone FROM shippers WHERE ShipperID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$shipper = $result->fetch_assoc();
$stmt->close();

if (!$shipper) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shipperName = trim($_POST['ShipperName'] ?? '');
    $phone = trim($_POST['Phone'] ?? '');

    if (!empty($shipperName)) {
        $updateStmt = $conn->prepare("UPDATE shippers SET ShipperName = ?, Phone = ? WHERE ShipperID = ?");
        if ($updateStmt) {
            $updateStmt->bind_param("ssi", $shipperName, $phone, $id);

            if ($updateStmt->execute()) {
                $updateStmt->close();
                header("Location: index.php");
                exit;
            } else {
                $error = 'Có lỗi xảy ra khi cập nhật.';
            }
            $updateStmt->close();
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
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-4">Cập Nhật Thông Tin Nhân Viên Giao Hàng</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="edit.php?id=<?= htmlspecialchars($id) ?>" method="POST">
                <div class="mb-3">
                    <label for="ShipperName" class="form-label font-weight-bold">
                        Tên nhân viên giao hàng <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="ShipperName" 
                           name="ShipperName" 
                           value="<?= htmlspecialchars($shipper['ShipperName']) ?>" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="Phone" class="form-label font-weight-bold">Số điện thoại</label>
                    <input type="text" 
                           class="form-control" 
                           id="Phone" 
                           name="Phone" 
                           value="<?= htmlspecialchars($shipper['Phone'] ?? '') ?>">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="index.php" class="btn btn-secondary">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '/var/www/src/includes/admin/footer.php'; ?>