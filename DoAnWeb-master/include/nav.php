<?php
session_start();
if (isset($_SESSION['cart'])) {
    $totalItems = array_sum($_SESSION['cart']);
} else {
    $totalItems = 0;
}
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <div class="row w-100">
            <div class="col-9 d-flex align-items-center">
                <a class="navbar-brand" href="#">BÁN HOA</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav d-flex justify-content-between w-100">
                        <a class="nav-link fw-bold" aria-current="page" href="index.php">TRANG CHỦ</a>
                        <a class="nav-link fw-bold" href="/Topic.php">CHỦ ĐỀ</a>
                        <a class="nav-link fw-bold" href="#">KIỂU DÁNG</a>
                        <a class="nav-link fw-bold" href="#">HOA TƯƠI</a>
                        <a class="nav-link fw-bold" href="#">MÀU SẮC</a>
                        <a class="nav-link fw-bold" href="#">BỘ SƯU TẬP</a>
                        <a class="nav-link fw-bold" href="#">QUÀ TẶNG KÈM</a>
                    </div>
                </div>
            </div>

            <div class="col-3 d-flex justify-content-end align-items-center">
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="user-info d-flex align-items-center me-3">
                        <span class="navbar-text fw-bold user-name me-3">
                            Chào, <?php echo $_SESSION['username']; ?>
                        </span>
                        <a href="logout.php" class="btn btn-outline-danger logout-btn">Đăng xuất</a>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-primary me-3">Đăng nhập</a>
                <?php endif; ?>
                <a href="cart.php" id="cart-btn" class="btn btn-outline-success d-flex align-items-center">
                    <i class="bi bi-cart cart-count me-2"></i>
                    <?php echo "$totalItems"; ?>
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartButton = document.getElementById('cart-btn');
        cartButton.addEventListener('click', function(event) {
            event.preventDefault();
            fetch('cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Cập nhật giỏ hàng thành công:', data.message);
                        window.location.href = 'cart.php';
                    } else {
                        console.error('Lỗi khi cập nhật giỏ hàng:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Lỗi hệ thống:', error);
                    window.location.href = 'cart.php';
                });
        });
    });
</script>