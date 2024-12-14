<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hệ thống</title>
    <link rel="stylesheet" href="/admin/css/dashboard.css"> <!-- Đường dẫn tới CSS -->
</head>
<body>
    <div class="wrapper">
        <!-- Thanh bên trái -->
        <aside class="sidebar">
            <div class="profile">
            <img src="/admin/img/image.png" alt="Avatar" width="80  " height="80">
            <p>Admin<br>Chào mừng bạn trở lại</p>
            </div>
            <nav>
                <ul>
                    <li><a href="indexadmin.php?action=admin_dashboard">Bảng điều khiển</a></li>
                    <li><a href="indexadmin.php?action=manage_products">Quản lý sản phẩm</a></li>

                    </ul>
            </nav>
        </aside>

        <!-- Nội dung chính -->
        <main class="content">
            <?php
             if (isset($content)) {
                echo $content;
            }
            ?>
        </main>
    </div>
</body>
</html>
