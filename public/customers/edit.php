<?php
$pageTitle = 'Cập Nhật Khách hàng';

require_once '/var/www/src/config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

$error = '';

// Lấy thông tin hiện tại của khách hàng
$stmt = $conn->prepare("SELECT CustomerID, CustomerName, ContactName, Address, City, PostalCode, Country FROM customers WHERE CustomerID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();
$stmt->close();

if (!$customer) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = trim($_POST['CustomerName'] ?? '');
    $contactName  = trim($_POST['ContactName'] ?? '');
    $address      = trim($_POST['Address'] ?? '');
    $city         = trim($_POST['City'] ?? '');
    $postalCode   = trim($_POST['PostalCode'] ?? '');
    $country      = trim($_POST['Country'] ?? '');

    if (!empty($customerName)) {
        $updateStmt = $conn->prepare("UPDATE customers SET CustomerName = ?, ContactName = ?, Address = ?, City = ?, PostalCode = ?, Country = ? WHERE CustomerID = ?");
        if ($updateStmt) {
            $updateStmt->bind_param("ssssssi", $customerName, $contactName, $address, $city, $postalCode, $country, $id);

            if ($updateStmt->execute()) {
                $updateStmt->close();
                header("Location: index.php");
                exit;
            } else {
                $error = 'Có lỗi xảy ra khi cập nhật thông tin.';
            }
            $updateStmt->close();
        }
    } else {
        $error = 'Vui lòng nhập tên khách hàng!';
    }
}

require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Cập Nhật Thông Tin Khách Hàng</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="edit.php?id=<?= htmlspecialchars($id) ?>" method="POST">
                <div class="mb-3">
                    <label for="CustomerName" class="form-label font-weight-bold">
                        Tên khách hàng <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="CustomerName" 
                           name="CustomerName" 
                           value="<?= htmlspecialchars($customer['CustomerName']) ?>" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="ContactName" class="form-label font-weight-bold">Tên người liên hệ</label>
                    <input type="text" 
                           class="form-control" 
                           id="ContactName" 
                           name="ContactName" 
                           value="<?= htmlspecialchars($customer['ContactName'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="Address" class="form-label font-weight-bold">Địa chỉ</label>
                    <input type="text" 
                           class="form-control" 
                           id="Address" 
                           name="Address" 
                           value="<?= htmlspecialchars($customer['Address'] ?? '') ?>">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="City" class="form-label font-weight-bold">Thành phố</label>
                        <input type="text" 
                               class="form-control" 
                               id="City" 
                               name="City" 
                               value="<?= htmlspecialchars($customer['City'] ?? '') ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="PostalCode" class="form-label font-weight-bold">Mã bưu chính</label>
                        <input type="text" 
                               class="form-control" 
                               id="PostalCode" 
                               name="PostalCode" 
                               value="<?= htmlspecialchars($customer['PostalCode'] ?? '') ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="Country" class="form-label font-weight-bold">Quốc gia</label>
                        <input type="text" 
                               class="form-control" 
                               id="Country" 
                               name="Country" 
                               value="<?= htmlspecialchars($customer['Country'] ?? '') ?>">
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="index.php" class="btn btn-secondary">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '/var/www/src/includes/admin/footer.php'; ?>