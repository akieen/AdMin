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

if (isset($_GET['id'])) {
    $productId = (int)$_GET['id'];

    // Kiểm tra nếu sản phẩm có tồn tại
    $checkQuery = "SELECT id FROM sanpham WHERE id = :id";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->bindValue(':id', $productId, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // Truy vấn xóa sản phẩm
        $deleteQuery = "DELETE FROM sanpham WHERE id = :id";
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->bindValue(':id', $productId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Sau khi xóa thành công, chuyển hướng về trang quản lý sản phẩm
            header('Location: indexadmin.php?page_layout=manage_product');
            exit();
        } else {
            echo "<script>alert('Xóa sản phẩm không thành công!');</script>";
        }
    } else {
        echo "<script>alert('Sản phẩm không tồn tại!');</script>";
    }
} else {
    echo "<script>alert('Không có ID sản phẩm!');</script>";
}
?>
