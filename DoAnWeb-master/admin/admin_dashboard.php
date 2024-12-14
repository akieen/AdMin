<?php
// Kết nối tới cơ sở dữ liệu
$host = '127.0.0.1';
$db = 'banhoa';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
}

// Truy vấn dữ liệu
$totalCustomersQuery = "SELECT COUNT(*) AS total FROM users";
$totalProductsQuery = "SELECT COUNT(*) AS total FROM sanpham";
$totalOrdersQuery = "SELECT COUNT(*) AS total FROM cart";

$totalCustomers = $pdo->query($totalCustomersQuery)->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
$totalProducts = $pdo->query($totalProductsQuery)->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
$totalOrders = $pdo->query($totalOrdersQuery)->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// Nội dung hiển thị
ob_start();
?>

<div class="content">
    <div class="container">
        <h1>Bảng Điều Khiển</h1>

        <!-- Summary Cards -->
        <div class="summary">
            <div class="card">
                <h3>Tổng Khách Hàng</h3>
                <p><?= $totalCustomers ?> khách hàng</p>
            </div>
            <div class="card">
                <h3>Tổng Sản Phẩm</h3>
                <p><?= $totalProducts ?> sản phẩm</p>
            </div>
            <div class="card">
                <h3>Tổng Đơn Hàng</h3>
                <p><?= $totalOrders ?> đơn hàng</p>
            </div>
        </div>

        <div class="logout-container">
        <a href="/DOANWEB-MASTER/logout.php" class="btn btn-outline-danger logout-btn">Đăng xuất</a>        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include 'layout.php'; // Nhúng layout chung