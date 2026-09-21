<?php
$pageTitle = 'Cập nhật Nhà cung cấp';
require_once '/var/www/src/config/database.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: index.php"); exit; }

$stmt = $conn->prepare("SELECT * FROM suppliers WHERE SupplierID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$supplier = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$supplier) { header("Location: index.php"); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplierName = trim($_POST['SupplierName'] ?? '');
    $contactName  = trim($_POST['ContactName'] ?? '');
    $address      = trim($_POST['Address'] ?? '');
    $city         = trim($_POST['City'] ?? '');
    $postalCode   = trim($_POST['PostalCode'] ?? '');
    $country      = trim($_POST['Country'] ?? '');
    $phone        = trim($_POST['Phone'] ?? '');

    if (!empty($supplierName)) {
        $updateStmt = $conn->prepare("UPDATE suppliers SET SupplierName=?, ContactName=?, Address=?, City=?, PostalCode=?, Country=?, Phone=? WHERE SupplierID=?");
        $updateStmt->bind_param("sssssssi", $supplierName, $contactName, $address, $city, $postalCode, $country, $phone, $id);
        if ($updateStmt->execute()) {
            $updateStmt->close();
            header("Location: index.php");
            exit;
        } else { $error = 'Lỗi cập nhật.'; }
        $updateStmt->close();
    } else { $error = 'Vui lòng nhập tên nhà cung cấp!'; }
}

require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark"><h4 class="mb-0">Sửa Nhà Cung Cấp</h4></div>
        <div class="card-body">
            <?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <form action="edit.php?id=<?= htmlspecialchars($id) ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Tên nhà cung cấp <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="SupplierName" value="<?= htmlspecialchars($supplier['SupplierName']) ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Người liên hệ</label>
                        <input type="text" class="form-control" name="ContactName" value="<?= htmlspecialchars($supplier['ContactName'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="Phone" value="<?= htmlspecialchars($supplier['Phone'] ?? '') ?>">
                    </div>
                </div>
                <div class="mb-3"><label class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" name="Address" value="<?= htmlspecialchars($supplier['Address'] ?? '') ?>">
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3"><label class="form-label">Thành phố</label><input type="text" class="form-control" name="City" value="<?= htmlspecialchars($supplier['City'] ?? '') ?>"></div>
                    <div class="col-md-4 mb-3"><label class="form-label">Mã bưu chính</label><input type="text" class="form-control" name="PostalCode" value="<?= htmlspecialchars($supplier['PostalCode'] ?? '') ?>"></div>
                    <div class="col-md-4 mb-3"><label class="form-label">Quốc gia</label><input type="text" class="form-control" name="Country" value="<?= htmlspecialchars($supplier['Country'] ?? '') ?>"></div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="index.php" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '/var/www/src/includes/admin/footer.php'; ?>