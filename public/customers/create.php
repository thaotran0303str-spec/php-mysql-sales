<?php
$pageTitle = 'Thêm Khách hàng mới';

require_once '/var/www/src/config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = trim($_POST['CustomerName'] ?? '');
    $contactName  = trim($_POST['ContactName'] ?? '');
    $address      = trim($_POST['Address'] ?? '');
    $city         = trim($_POST['City'] ?? '');
    $postalCode   = trim($_POST['PostalCode'] ?? '');
    $country      = trim($_POST['Country'] ?? '');

    if (!empty($customerName)) {
        $sql = "INSERT INTO customers (CustomerName, ContactName, Address, City, PostalCode, Country) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('ssssss', $customerName, $contactName, $address, $city, $postalCode, $country);

            if ($stmt->execute()) {
                $stmt->close();
                header('Location: index.php');
                exit;
            } else {
                $error = 'Không thể thêm khách hàng vào cơ sở dữ liệu.';
            }
            $stmt->close();
        } else {
            $error = 'Lỗi câu lệnh cơ sở dữ liệu!';
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
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Thêm Khách Hàng Mới</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="create.php" method="POST">
                <div class="mb-3">
                    <label for="CustomerName" class="form-label font-weight-bold">
                        Tên khách hàng <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="CustomerName" 
                           name="CustomerName" 
                           placeholder="Ví dụ: Công ty TNHH A, Nguyễn Văn B..." 
                           required>
                </div>

                <div class="mb-3">
                    <label for="ContactName" class="form-label font-weight-bold">Tên người liên hệ</label>
                    <input type="text" 
                           class="form-control" 
                           id="ContactName" 
                           name="ContactName" 
                           placeholder="Ví dụ: Trần Thị C">
                </div>

                <div class="mb-3">
                    <label for="Address" class="form-label font-weight-bold">Địa chỉ</label>
                    <input type="text"
                    class="form-control" 
                           id="Address" 
                           name="Address" 
                           placeholder="Ví dụ: 123 Đường Nguyễn Huệ">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="City" class="form-label font-weight-bold">Thành phố</label>
                        <input type="text" 
                               class="form-control" 
                               id="City" 
                               name="City" 
                               placeholder="Ví dụ: Hồ Chí Minh">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="PostalCode" class="form-label font-weight-bold">Mã bưu chính</label>
                        <input type="text" 
                               class="form-control" 
                               id="PostalCode" 
                               name="PostalCode" 
                               placeholder="Ví dụ: 700000">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="Country" class="form-label font-weight-bold">Quốc gia</label>
                        <input type="text" 
                               class="form-control" 
                               id="Country" 
                               name="Country" 
                               placeholder="Ví dụ: Việt Nam">
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-success">Lưu lại</button>
                    <a href="index.php" class="btn btn-secondary">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '/var/www/src/includes/admin/footer.php'; ?>