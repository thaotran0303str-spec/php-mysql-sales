<?php
$pageTitle = 'Thêm sản phẩm';

// 1. Kết nối database ngay tại thư mục products
require_once __DIR__ . '/database.php';

// Lấy danh sách Danh mục & Nhà cung cấp để hiển thị trong ô chọn (Select Box)
$categories = $conn->query("SELECT * FROM categories");
$suppliers  = $conn->query("SELECT * FROM suppliers");

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code       = trim($_POST['ProductCode']);
    $name       = trim($_POST['ProductName']);
    $catId      = !empty($_POST['CategoryID']) ? $_POST['CategoryID'] : NULL;
    $supId      = !empty($_POST['SupplierID']) ? $_POST['SupplierID'] : NULL;
    $unit       = trim($_POST['Unit']);
    $price      = (float)$_POST['Price'];
    $stock      = (int)$_POST['StockQuantity'];
    $isActive   = isset($_POST['IsActive']) ? 1 : 0;

    if (!empty($code) && !empty($name)) {
        // Thêm sản phẩm vào bảng products (Chuẩn hóa câu lệnh Prepared Statement)
        $stmt = $conn->prepare("INSERT INTO products (ProductCode, ProductName, CategoryID, SupplierID, Unit, Price, StockQuantity, IsActive) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiisdii", $code, $name, $catId, $supId, $unit, $price, $stock, $isActive);
        
        if ($stmt->execute()) {
            // Thêm thành công, chuyển về lại trang danh sách sản phẩm
            header("Location: /admin/products/index.php");
            exit;
        } else {
            $error = "Lỗi khi thêm sản phẩm: " . $stmt->error;
        }
    } else {
        $error = "Vui lòng nhập đầy đủ Mã sản phẩm và Tên sản phẩm!";
    }
}

// Gọi giao diện Header & Navbar
require_once '/var/www/src/includes/admin/header.php';
require_once '/var/www/src/includes/admin/navbar.php';
?>

<div class="container mt-4">
    <h2>Thêm sản phẩm mới</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Mã SP <span class="text-danger">*</span></label>
                <input type="text" name="ProductCode" class="form-control" placeholder="Ví dụ: SP004" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                <input type="text" name="ProductName" class="form-control" placeholder="Tên sản phẩm..." required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Danh mục</label>
                <select name="CategoryID" class="form-select">
                    <option value="">-- Chọn danh mục --</option>
                    <?php if ($categories && $categories->num_rows > 0): ?><?php while ($c = $categories->fetch_assoc()): ?>
                            <option value="<?= $c['CategoryID'] ?>"><?= htmlspecialchars($c['CategoryName']) ?></option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Nhà cung cấp</label>
                <select name="SupplierID" class="form-select">
                    <option value="">-- Chọn nhà cung cấp --</option>
                    <?php if ($suppliers && $suppliers->num_rows > 0): ?>
                        <?php while ($s = $suppliers->fetch_assoc()): ?>
                            <option value="<?= $s['SupplierID'] ?>"><?= htmlspecialchars($s['SupplierName']) ?></option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Đơn vị tính</label>
                <input type="text" name="Unit" class="form-control" placeholder="Cái, Chiếc, Bọ, ...">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Giá bán</label>
                <input type="number" step="1000" name="Price" class="form-control" value="0" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Số lượng tồn kho</label>
                <input type="number" name="StockQuantity" class="form-control" value="0" required>
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-check mt-2">
                    <input type="checkbox" name="IsActive" class="form-check-input" value="1" id="IsActive" checked>
                    <label class="form-check-label" for="IsActive">Kích hoạt kinh doanh (Đang bán)</label>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-success">Lưu sản phẩm</button>
        <a href="/admin/products/index.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<?php 
require_once '/var/www/src/includes/admin/footer.php';
$conn->close();
?>