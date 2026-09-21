<?php
$pageTitle = 'Thêm Nhà cung cấp';
require_once '/var/www/src/config/database.php';

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
        $sql = "INSERT INTO suppliers (SupplierName, ContactName, Address, City, PostalCode, Country, Phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('sssssss', $supplierName, $contactName, $address, $city, $postalCode, $country, $phone);
            if ($stmt->execute()) {
                $stmt->close();
                header('Location: index.php');
                exit;
            } else { $error = 'Lỗi lưu dữ liệu.'; }
            $stmt->close();
        }
    } else { $error = 'Vui lòng nhập tên nhà cung cấp!'; }
}

require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white"><h4 class="mb-0">Thêm Nhà Cung Cấp</h4></div>
        <div class="card-body">
            <?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <form action="create.php" method="POST">
                <div class="mb-3">
                    <label class="form-label font-weight-bold">Tên nhà cung cấp <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="SupplierName" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Người liên hệ</label>
                        <input type="text" class="form-control" name="ContactName">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="Phone">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" name="Address">
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3"><label class="form-label">Thành phố</label><input type="text" class="form-control" name="City"></div>
                    <div class="col-md-4 mb-3"><label class="form-label">Mã bưu chính</label><input type="text" class="form-control" name="PostalCode"></div><div class="col-md-4 mb-3"><label class="form-label">Quốc gia</label><input type="text" class="form-control" name="Country"></div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Lưu lại</button>
                    <a href="index.php" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '/var/www/src/includes/admin/footer.php'; ?>