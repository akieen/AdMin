<?php
header('Content-Type: application/json');
try {
    $dsn = 'mysql:host=localhost;dbname=banhoa;charset=utf8mb4';
    $username = 'root';
    $password = '';
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $productId = 0;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        if (isset($data['product_id'])) {
            $productId = $data['product_id'];
            error_log("Dữ liệu nhận được từ client: " . print_r($data, true));
        } else {
            error_log("Không có dữ liệu 'product_id' trong yêu cầu.");
            echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
            exit;
        }
    }
    $userId = 1;

    $query = 'SELECT quantity FROM cart_details WHERE cart_id = :cart_id AND product_id = :product_id';
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':cart_id' => $userId,  // Thay thế user_id bằng cart_id
        ':product_id' => $productId,
    ]);
    $cartItem = $stmt->fetch();
    if ($cartItem) {
        $updateQuery = 'UPDATE cart_details SET quantity = quantity + 1 WHERE cart_id = :cart_id AND product_id = :product_id';
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([
            ':cart_id' => $userId,
            ':product_id' => $productId,
        ]);
    } else {
        $insertQuery = 'INSERT INTO cart_details (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)';
        $stmt = $pdo->prepare($insertQuery);
        $stmt->execute([
            ':cart_id' => $userId,
            ':product_id' => $productId,
            ':quantity' => 1,
        ]);
    }
    $countQuery = 'SELECT SUM(quantity) AS cart_count FROM cart_details WHERE cart_id = :cart_id';
    $stmt = $pdo->prepare($countQuery);
    $stmt->execute([':cart_id' => $userId]);
    $cartCount = $stmt->fetchColumn();

    echo json_encode([
        'success' => true,
        'cart_count' => $cartCount,
        'message' => 'Sản phẩm đã được thêm vào giỏ hàng thành công.',
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Đã xảy ra lỗi: ' . $e->getMessage(),
    ]);
}
