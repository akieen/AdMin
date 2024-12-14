<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "banhoa";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin sản phẩm dựa vào id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM sanpham WHERE id = $id");
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("Không tìm thấy sản phẩm với ID này.");
    }
} else {
    die("Không có ID sản phẩm.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $ten_san_pham = $_POST['ten_san_pham'];
    $gia = $_POST['gia'];
    $mo_ta = $_POST['mo_ta'];
    $danh_gia = $_POST['danh_gia'];
    $chu_de_id = $_POST['chu_de_id'];
    $doi_tuong_id = $_POST['doi_tuong_id'];
    $kieu_dang_id = $_POST['kieu_dang_id'];
    $mau_sac_id = $_POST['mau_sac_id'];
    $bo_suu_tap_id = $_POST['bo_suu_tap_id'];

    // Xử lý hình ảnh upload
    $target_file = $product['hinh_anh']; // Mặc định giữ nguyên hình ảnh cũ
    if (!empty($_FILES["hinh_anh"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["hinh_anh"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra nếu là hình ảnh
        if (getimagesize($_FILES["hinh_anh"]["tmp_name"]) === false) {
            die("File không phải là hình ảnh.");
        }

        // Kiểm tra kích thước file (tối đa 2MB)
        if ($_FILES["hinh_anh"]["size"] > 2000000) {
            die("File quá lớn. Vui lòng chọn file dưới 2MB.");
        }

        // Kiểm tra loại file
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            die("Chỉ hỗ trợ file JPG, JPEG, PNG.");
        }

        // Di chuyển file vào thư mục upload
        if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $target_file)) {
            echo "Hình ảnh đã được upload thành công.";
        } else {
            echo "Có lỗi khi tải hình ảnh lên.";
        }
    }

    // Chuẩn bị câu lệnh SQL để cập nhật sản phẩm
    $sql = "UPDATE sanpham SET ten_san_pham = '$ten_san_pham', gia = '$gia', mo_ta = '$mo_ta', hinh_anh = '$target_file', danh_gia = '$danh_gia', chu_de_id = '$chu_de_id', doi_tuong_id = '$doi_tuong_id', kieu_dang_id = '$kieu_dang_id', mau_sac_id = '$mau_sac_id', bo_suu_tap_id = '$bo_suu_tap_id' WHERE id = $id";

    // Kiểm tra và thực thi câu lệnh SQL
    if ($conn->query($sql) === TRUE) {
        $success_message = "Sản phẩm đã được cập nhật thành công!";
        // Thực hiện chuyển hướng sau 2 giây
        header("Location: indexadmin.php"); 
        exit();
    } else {
        $error_message = "Lỗi: " . $conn->error;
    }    
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Sản Phẩm</title>
</head>
<body>
    <h2>Cập Nhật Thông Tin Sản Phẩm</h2>
    <button type="button" onclick="window.history.back();">Quay Lại</button>

    <!-- Thông báo thành công hoặc lỗi -->
    <?php if (isset($success_message)) { ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php } ?>
    <?php if (isset($error_message)) { ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php } ?>

    <form action="update.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <label for="ten_san_pham">Tên Sản Phẩm:</label>
        <input type="text" id="ten_san_pham" name="ten_san_pham" value="<?php echo $product['ten_san_pham']; ?>" required><br><br>

        <label for="gia">Giá:</label>
        <input type="number" id="gia" name="gia" step="0.01" value="<?php echo $product['gia']; ?>" required><br><br>

        <label for="mo_ta">Mô Tả:</label>
        <textarea id="mo_ta" name="mo_ta" rows="4" required><?php echo $product['mo_ta']; ?></textarea><br><br>

        <label for="hinh_anh">Hình Ảnh (nếu muốn thay đổi):</label>
        <input type="file" id="hinh_anh" name="hinh_anh"><br><br>

        <label for="danh_gia">Đánh Giá:</label>
        <input type="number" id="danh_gia" name="danh_gia" step="0.01" min="0" max="5" value="<?php echo $product['danh_gia']; ?>" required><br><br>

        <label for="chu_de_id">Chủ Đề:</label>
        <select id="chu_de_id" name="chu_de_id" required>
            <option value="1" <?php echo ($product['chu_de_id'] == 1) ? 'selected' : ''; ?>>Sinh nhật</option>
            <option value="2" <?php echo ($product['chu_de_id'] == 2) ? 'selected' : ''; ?>>Khai trương</option>
            <option value="3" <?php echo ($product['chu_de_id'] == 3) ? 'selected' : ''; ?>>Tình yêu</option>
            <option value="4" <?php echo ($product['chu_de_id'] == 4) ? 'selected' : ''; ?>>Chúc Mừng</option>
            <option value="5" <?php echo ($product['chu_de_id'] == 5) ? 'selected' : ''; ?>>Kỷ Niệm</option>
            <option value="6" <?php echo ($product['chu_de_id'] == 6) ? 'selected' : ''; ?>>Tiệc Cưới</option>
            <option value="7" <?php echo ($product['chu_de_id'] == 7) ? 'selected' : ''; ?>>Tết Nguyên Đán</option>
            <option value="8" <?php echo ($product['chu_de_id'] == 8) ? 'selected' : ''; ?>>Lễ Phục Sinh</option>
            <option value="9" <?php echo ($product['chu_de_id'] == 9) ? 'selected' : ''; ?>>Đặc Biệt</option>
        </select><br><br>

        <label for="doi_tuong_id">Đối Tượng:</label>
        <select id="doi_tuong_id" name="doi_tuong_id" required>
            <option value="1" <?php echo ($product['doi_tuong_id'] == 1) ? 'selected' : ''; ?>>Học sinh</option>
            <option value="2" <?php echo ($product['doi_tuong_id'] == 2) ? 'selected' : ''; ?>>Người yêu</option>
            <option value="3" <?php echo ($product['doi_tuong_id'] == 3) ? 'selected' : ''; ?>>Bạn bè</option>
            <option value="4" <?php echo ($product['doi_tuong_id'] == 4) ? 'selected' : ''; ?>>Bạn Cũ</option>
            <option value="5" <?php echo ($product['doi_tuong_id'] == 5) ? 'selected' : ''; ?>>Cha Mẹ</option>
            <option value="6" <?php echo ($product['doi_tuong_id'] == 6) ? 'selected' : ''; ?>>Anh Chị Em</option>
            <option value="7" <?php echo ($product['doi_tuong_id'] == 7) ? 'selected' : ''; ?>>Thầy Cô</option>
            <option value="8" <?php echo ($product['doi_tuong_id'] == 8) ? 'selected' : ''; ?>>Sếp</option>
            <option value="9" <?php echo ($product['doi_tuong_id'] == 9) ? 'selected' : ''; ?>>Đối Tác</option>
        </select><br><br>

        <label for="kieu_dang_id">Kiểu Dáng:</label>
        <select id="kieu_dang_id" name="kieu_dang_id" required>
            <option value="1" <?php echo ($product['kieu_dang_id'] == 1) ? 'selected' : ''; ?>>Tròn</option>
            <option value="2" <?php echo ($product['kieu_dang_id'] == 2) ? 'selected' : ''; ?>>Thẳng</option>
            <option value="3" <?php echo ($product['kieu_dang_id'] == 3) ? 'selected' : ''; ?>>Lộng lẫy</option>
            <option value="4" <?php echo ($product['kieu_dang_id'] == 4) ? 'selected' : ''; ?>>Hoa Xếp Lớn</option>
            <option value="5" <?php echo ($product['kieu_dang_id'] == 5) ? 'selected' : ''; ?>>Hoa Trang Trí</option>
            <option value="6" <?php echo ($product['kieu_dang_id'] == 6) ? 'selected' : ''; ?>>Hoa Chậu Nhỏ</option>
            <option value="7" <?php echo ($product['kieu_dang_id'] == 7) ? 'selected' : ''; ?>>Hoa Nổi</option>
            <option value="8" <?php echo ($product['kieu_dang_id'] == 8) ? 'selected' : ''; ?>>Hoa Nổi Mọi Phía</option>
            <option value="9" <?php echo ($product['kieu_dang_id'] == 9) ? 'selected' : ''; ?>>Hoa Kiểu Cổ Điển</option>
        </select><br><br>

        <label for="mau_sac_id">Màu Sắc:</label>
        <select id="mau_sac_id" name="mau_sac_id" required>
            <option value="1" <?php echo ($product['mau_sac_id'] == 1) ? 'selected' : ''; ?>>Đỏ</option>
            <option value="2" <?php echo ($product['mau_sac_id'] == 2) ? 'selected' : ''; ?>>Vàng</option>
            <option value="3" <?php echo ($product['mau_sac_id'] == 3) ? 'selected' : ''; ?>>Trắng</option>
            <option value="4" <?php echo ($product['mau_sac_id'] == 4) ? 'selected' : ''; ?>>Tím</option>
            <option value="5" <?php echo ($product['mau_sac_id'] == 5) ? 'selected' : ''; ?>>Hồng Phấn</option>
            <option value="6" <?php echo ($product['mau_sac_id'] == 6) ? 'selected' : ''; ?>>Xanh Dương</option>
            <option value="7" <?php echo ($product['mau_sac_id'] == 7) ? 'selected' : ''; ?>>Xanh Lá</option>
            <option value="8" <?php echo ($product['mau_sac_id'] == 8) ? 'selected' : ''; ?>>Vàng Nhạt</option>
            <option value="9" <?php echo ($product['mau_sac_id'] == 9) ? 'selected' : ''; ?>>Đen</option>
        </select><br><br>
        <label for="bo_suu_tap_id">Bộ Sưu Tập:</label>
        <select id="bo_suu_tap_id" name="bo_suu_tap_id" required>
            <option value="1" <?php echo ($product['bo_suu_tap_id'] == 1) ? 'selected' : ''; ?>>Hoa mùa hè</option>
            <option value="2" <?php echo ($product['bo_suu_tap_id'] == 2) ? 'selected' : ''; ?>>Hoa đặc biệt</option>
            <option value="3" <?php echo ($product['bo_suu_tap_id'] == 3) ? 'selected' : ''; ?>>Bộ Sưu Tập Mùa Đông</option>
            <option value="4" <?php echo ($product['bo_suu_tap_id'] == 4) ? 'selected' : ''; ?>>Bộ Sưu Tập Cổ Điển</option>
            <option value="5" <?php echo ($product['bo_suu_tap_id'] == 5) ? 'selected' : ''; ?>>Bộ Sưu Tập Đặc Biệt</option>
            <option value="6" <?php echo ($product['bo_suu_tap_id'] == 6) ? 'selected' : ''; ?>>Bộ Sưu Tập Cảm Hứng</option>
            <option value="7" <?php echo ($product['bo_suu_tap_id'] == 7) ? 'selected' : ''; ?>>Bộ Sưu Tập Tình Bạn</option>
            <option value="8" <?php echo ($product['bo_suu_tap_id'] == 8) ? 'selected' : ''; ?>>Bộ Sưu Tập Hoa Tết</option>
        </select><br><br>
        <button type="submit">Cập Nhật Sản Phẩm</button>
    </form>
</body>
<style>
    /* Cấu hình chung */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

h2 {
    text-align: center;
    color: #333;
    margin-top: 30px;
}

/* Định dạng form */
form {
    width: 50%;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

label {
    font-size: 16px;
    margin
