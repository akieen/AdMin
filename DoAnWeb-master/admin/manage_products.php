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

// Kiểm tra nếu có yêu cầu xóa sản phẩm
if (isset($_GET['action']) && $_GET['action'] == 'delete_product' && isset($_GET['id'])) {
    $productId = (int)$_GET['id'];

    // Truy vấn xóa sản phẩm theo ID
    $deleteQuery = "DELETE FROM sanpham WHERE id = :id";
    $stmt = $pdo->prepare($deleteQuery);
    $stmt->bindValue(':id', $productId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Sản phẩm đã được xóa thành công!'); window.location = 'index.php?action=manage_products';</script>";
    } else {
        echo "<script>alert('Xóa sản phẩm không thành công!');</script>";
    }
}

// Truy vấn danh sách sản phẩm và phân trang
$itemsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// Truy vấn tổng số sản phẩm
$totalProductsQuery = "SELECT COUNT(*) AS total FROM sanpham";
$totalProducts = $pdo->query($totalProductsQuery)->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
$totalPages = ceil($totalProducts / $itemsPerPage);

// Truy vấn dữ liệu sản phẩm và liên kết với các bảng chủ đề, đối tượng, màu sắc, kiểu dáng, bộ sưu tập
$productQuery = "
    SELECT sp.*, ch.ten_chu_de AS chu_de_name, dt.ten_doi_tuong AS doi_tuong_name, 
           ms.ten_mau_sac AS mau_sac_name, kd.ten_kieu_dang AS kieu_dang_name, bst.ten_bo_suu_tap AS bo_suu_tap_name
    FROM sanpham sp
    LEFT JOIN chude ch ON sp.chu_de_id = ch.id
    LEFT JOIN doituong dt ON sp.doi_tuong_id = dt.id
    LEFT JOIN mausac ms ON sp.mau_sac_id = ms.id
    LEFT JOIN kieudang kd ON sp.kieu_dang_id = kd.id
    LEFT JOIN bosuutap bst ON sp.bo_suu_tap_id = bst.id
    LIMIT :offset, :itemsPerPage
";
$stmt = $pdo->prepare($productQuery);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Nội dung hiển thị
ob_start();
?>

<body>
    <div class="container">
        <h1>Danh Sách Sản Phẩm</h1>

        <div class="search-bar">
            <input type="text" placeholder="Tìm kiếm sản phẩm...">
            <button>Tìm Kiếm</button>
        </div>

        <div>
            <a href="add.php" class="btn btn-green">Tạo mới sản phẩm</a>

            <a href="#" class="btn btn-blue">In dữ liệu</a>
            <a href="#" class="btn btn-red" onclick="return confirm('Bạn chắc chắn muốn xóa tất cả sản phẩm?')">Xóa tất cả</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Ảnh</th>
                        <th>Mô Tả</th>
                        <th>Đánh giá</th>
                        <th>Giá tiền</th>
                        <th>Chủ đề</th>
                        <th>Đối tượng</th>
                        <th>Kiểu dáng</th>
                        <th>Màu sắc</th>
                        <th>Bộ sưu tập</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['id']) ?></td>
                                <td><?= htmlspecialchars($product['ten_san_pham']) ?></td>
                                <td>
                                    <?php if (!empty($product['hinh_anh'])): ?>
                                        <img src="<?= htmlspecialchars($product['hinh_anh']) ?>" alt="<?= htmlspecialchars($product['ten_san_pham']) ?>" width="50">
                                    <?php else: ?>
                                        Chưa có hình ảnh
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($product['mo_ta']) ?></td>
                                <td><?= htmlspecialchars($product['danh_gia']) ?></td>
                                <td><?= number_format($product['gia'], 0, ',', '.') ?> đ</td>
                                <td><?= htmlspecialchars($product['chu_de_name']) ?></td>
                                <td><?= htmlspecialchars($product['doi_tuong_name']) ?></td>
                                <td><?= htmlspecialchars($product['kieu_dang_name']) ?></td>
                                <td><?= htmlspecialchars($product['mau_sac_name']) ?></td>
                                <td><?= htmlspecialchars($product['bo_suu_tap_name']) ?></td>
                                <td>
                                <a href="delete.php?action=delete_product&id=<?= $product['id'] ?>" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')">Xóa</a>
                                <a href="update.php?action=delete_product&id=<?= $product['id'] ?>" onclick="return confirm('bạn chắc là muốn sửa thông tin')">sửa</a>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12">Không có sản phẩm nào để hiển thị.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?action=manage_products&page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</body>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
    margin: 20px 0;
    color: #333;
}

.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.table-container {
    overflow-x: auto;
    margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    margin-bottom: 20px;
}

table th, table td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

table th {
    background-color: #007bff;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #e9ecef;
}

button, .btn {
    padding: 10px 15px;
    font-size: 14px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 5px;
}

.btn {
    display: inline-block;
    text-align: center;
    text-decoration: none;
}

.btn-green {
    background-color: #28a745;
    color: #fff;
}

.btn-blue {
    background-color: #007bff;
    color: #fff;
}

.btn-red {
    background-color: #dc3545;
    color: #fff;
}

.btn:hover {
    opacity: 0.9;
}

.search-bar {
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.search-bar input {
    width: 300px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.search-bar button {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
}

.search-bar button:hover {
    opacity: 0.9;
}
/* Định dạng cho thanh phân trang */


</style>
<?php
$content = ob_get_clean();
include 'layout.php';
?>
