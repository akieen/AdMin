<?php
// Xử lý các hành động

// Xử lý các hành động
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'manage_products':
            include 'manage_products.php';
            break;

        // Các hành động khác

        default:
            include 'admin_dashboard.php';
            break;
    }
} else {
    include 'admin_dashboard.php'; // Trang mặc định
}


?>