<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root"; // Tùy thuộc vào cấu hình của bạn
$password = "";
$dbname = "banhoa"; // Tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
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
    $target_dir = "uploads/"; // Thư mục lưu hình ảnh
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

    // Chuẩn bị câu lệnh SQL để thêm sản phẩm
    $sql = "INSERT INTO sanpham (ten_san_pham, gia, mo_ta, hinh_anh, danh_gia, chu_de_id, doi_tuong_id, kieu_dang_id, mau_sac_id, bo_suu_tap_id) 
            VALUES ('$ten_san_pham', '$gia', '$mo_ta', '$target_file', '$danh_gia', '$chu_de_id', '$doi_tuong_id', '$kieu_dang_id', '$mau_sac_id', '$bo_suu_tap_id')";

    // Kiểm tra và thực thi câu lệnh SQL
    if ($conn->query($sql) === TRUE) {
        $success_message = "Sản phẩm đã được thêm thành công!";
        // Thực hiện chuyển hướng sau 2 giây
        header("Location: indexadmin.php"); 
        exit();
    } else {
        $error_message = "Lỗi: " . $conn->error;
    }    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm</title>
</head>
<body>
    <h2>Thêm Sản Phẩm Mới</h2>
    <button type="button" onclick="window.history.back();">Quay Lại</button>

    <!-- Thông báo thành công hoặc lỗi -->
    <?php if (isset($success_message)) { ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php } ?>
    <?php if (isset($error_message)) { ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php } ?>

    <form action="add.php" method="POST" enctype="multipart/form-data">
        <label for="ten_san_pham">Tên Sản Phẩm:</label>
        <input type="text" id="ten_san_pham" name="ten_san_pham" required><br><br>

        <label for="gia">Giá:</label>
        <input type="number" id="gia" name="gia" step="0.01" required><br><br>

        <label for="mo_ta">Mô Tả:</label>
        <textarea id="mo_ta" name="mo_ta" rows="4" required></textarea><br><br>

        <label for="hinh_anh">Hình Ảnh:</label>
        <input type="file" id="hinh_anh" name="hinh_anh" required><br><br>

        <label for="danh_gia">Đánh Giá:</label>
        <input type="number" id="danh_gia" name="danh_gia" step="0.01" min="0" max="5" required><br><br>

        <label for="chu_de_id">Chủ Đề:</label>
        <select id="chu_de_id" name="chu_de_id" required>
            <option value="1">Sinh nhật</option>
            <option value="2">Khai trương</option>
            <option value="3">Tình yêu</option>
            <option value="4">Chúc Mừng</option>
            <option value="5">Kỷ Niệm</option>
            <option value="6">Tiệc Cưới</option>
            <option value="7">Tết Nguyên Đán</option>
            <option value="8">Lễ Phục Sinh</option>
            <option value="9">Đặc Biệt</option>
        </select><br><br>

        <label for="doi_tuong_id">Đối Tượng:</label>
        <select id="doi_tuong_id" name="doi_tuong_id" required>
            <option value="1">Học sinh</option>
            <option value="2">Người yêu</option>
            <option value="3">Bạn bè</option>
            <option value="4">Bạn Cũ</option>
            <option value="5">Cha Mẹ</option>
            <option value="6">Anh Chị Em</option>
            <option value="7">Thầy Cô</option>
            <option value="8">Sếp</option>
            <option value="9">Đối Tác</option>
        </select><br><br>

        <label for="kieu_dang_id">Kiểu Dáng:</label>
        <select id="kieu_dang_id" name="kieu_dang_id" required>
            <option value="1">Tròn</option>
            <option value="2">Thẳng</option>
            <option value="3">Lộng lẫy</option>
            <option value="4">Hoa Xếp Lớn</option>
            <option value="5">Hoa Trang Trí</option>
            <option value="6">Hoa Chậu Nhỏ</option>
            <option value="7">Hoa Nổi</option>
            <option value="8">Hoa Nổi Mọi Phía</option>
            <option value="9">Hoa Kiểu Cổ Điển</option>
        </select><br><br>

        <label for="mau_sac_id">Màu Sắc:</label>
        <select id="mau_sac_id" name="mau_sac_id" required>
            <option value="1">Đỏ</option>
            <option value="2">Vàng</option>
            <option value="3">Trắng</option>
            <option value="4">Tím</option>
            <option value="5">Hồng Phấn</option>
            <option value="6">Xanh Dương</option>
            <option value="7">Xanh Lá</option>
            <option value="8">Vàng Nhạt</option>
            <option value="9">Đen</option>
        </select><br><br>
        <label for="bo_suu_tap_id">Bộ Sưu Tập:</label>
        <select id="bo_suu_tap_id" name="bo_suu_tap_id" required>
            <option value="1">Hoa mùa hè</option>
            <option value="2">Hoa đặc biệt</option>
            <option value="3">Bộ Sưu Tập Mùa Đông</option>
            <option value="4">Bộ Sưu Tập Cổ Điển</option>
            <option value="5">Bộ Sưu Tập Đặc Biệt</option>
            <option value="6">Bộ Sưu Tập Cảm Hứng</option>
            <option value="7">Bộ Sưu Tập Tình Bạn</option>
            <option value="8">Bộ Sưu Tập Hoa Tết</option>
        </select><br><br>
        <button type="submit">Thêm Sản Phẩm</button>
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
    margin-bottom: 8px;
    display: block;
    color: #555;
}

input[type="text"], input[type="number"], textarea, select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button[type="submit"], button[type="button"] {
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

button[type="submit"]:hover, button[type="button"]:hover {
    background-color: #218838;
}

button[type="button"] {
    background-color: #007bff;
    margin-top: 10px;
}

button[type="button"]:hover {
    background-color: #0056b3;
}

/* Thông báo khi thành công */
.success-message {
    background-color: #28a745;
    color: white;
    padding: 10px;
    text-align: center;
    margin-bottom: 20px;
    border-radius: 5px;
}

/* Thông báo lỗi */
.error-message {
    background-color: #dc3545;
    color: white;
    padding: 10px;
    text-align: center;
    margin-bottom: 20px;
    border-radius: 5px;
}

select {
    margin-bottom: 20px;
}

</style>
</html>
