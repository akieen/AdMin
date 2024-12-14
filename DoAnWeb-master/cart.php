<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./assets/css/main.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Giỏ Hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 50px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-item .text {
            flex-grow: 1;
            padding-left: 15px;
        }

        .cart-item .text a {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }

        .cart-item .ctrl-qty {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .cart-item .ctrl-qty input {
            width: 50px;
            text-align: center;
            margin: 0 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .total {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .total .each-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .total .each-row:last-child {
            border-bottom: none;
        }

        .total strong {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .remove-item {
            color: #e74c3c;
            font-weight: bold;
            cursor: pointer;
        }

        .remove-item:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="row">
        <?php include './include/nav.php'; ?>
    </div>

    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $user_id = $_SESSION['user_id'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "banhoa";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT dc.product_id, s.ten_san_pham, dc.quantity, s.hinh_anh, s.gia
    FROM cart c
    JOIN cart_details dc ON c.id = dc.cart_id
    JOIN sanpham s ON dc.product_id = s.id
    WHERE c.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;
    $subtotal = 0;
    $vat = 0;
    $discount = 0;
    $fee = 0;
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="cart-item" data-id="' . $row['product_id'] . '">';
                        echo '<div class="img"><img src="' . $row['hinh_anh'] . '" alt="' . $row['ten_san_pham'] . '" class="img-fluid"></div>';
                        echo '<div class="text">';
                        echo '<a href="/shop-hoa/bo-hoa-tuoi/' . $row['product_id'] . '">' . $row['ten_san_pham'] . '</a>';
                        echo '<p><span>' . number_format($row['gia']) . ' đ</span></p>';
                        echo '<div class="ctrl-qty">';
                        echo '<a href="javascript:void(0);" class="minus" onclick="AddOrRemoveItems(this, false, ' . $row['product_id'] . ', ' . $row['gia'] . ');"><i class="bi bi-dash"></i></a>';
                        echo '<input class="txtQty" type="number" value="' . $row['quantity'] . '" onchange="HandleKeypress(this, event, ' . $row['product_id'] . ', ' . $row['gia'] . ')" onkeypress="HandleKeypress(this, event, ' . $row['product_id'] . ', ' . $row['gia'] . ')">';
                        echo '<a href="javascript:void(0);" class="plus" onclick="AddOrRemoveItems(this, true, ' . $row['product_id'] . ', ' . $row['gia'] . ');"><i class="bi bi-plus"></i></a>';
                        echo '</div>';
                        echo '</div>';
                        echo '<a class="close remove-item" href="javascript:void(0);" onclick="RemoveItem(' . $row['product_id'] . ')">X</a>';
                        echo '<div class="clearfix"></div>';
                        echo '</div>';

                        // Tính tổng tiền tạm tính
                        $subtotal += $row['quantity'] * $row['gia'];
                    }
                } else {
                    echo "Giỏ hàng của bạn hiện tại chưa có sản phẩm.";
                }
                ?>
            </div>

            <div class="col-md-3">
                <div class="total">
                    <div class="each-row">
                        <span>Tạm tính:</span>
                        <strong id="subtotal"><?php echo number_format($subtotal); ?> đ</strong>
                    </div>
                    <div class="each-row">
                        <span>Phụ phí: </span>
                        <strong id="sub-fee"><?php echo number_format($fee); ?> đ</strong>
                    </div>
                    <div class="each-row">
                        <span>Giảm giá: </span>
                        <strong id="discount">0 đ</strong>
                    </div>
                    <div class="each-row">
                        <span>Hóa đơn VAT: </span>
                        <strong id="vat">10%</strong>
                    </div>
                    <div class="each-row last">
                        <span>Tổng cộng: </span>
                        <strong id="total"><?php
                                            // Tính VAT, tổng tiền
                                            $vat = $subtotal * 0.1;
                                            $total = $subtotal + $vat - $discount + $fee;
                                            echo number_format($total); ?> đ</strong>
                    </div>
                    <div class="each-row">
                        <a href="#" class="e-buy btn btn-primary w-100">Đặt hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    $stmt->close();
    $conn->close();
    ?>
    <?php include './include/footer.php'; ?>
</body>

</html>