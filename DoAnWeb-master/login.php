<?php
session_start();
$host = 'localhost';
$db = 'banhoa';
$user = 'root';
$pass = '';
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    if (empty($user) || empty($pass)) {
        $error_message = "Tên đăng nhập và mật khẩu không được để trống.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $user);
            $stmt->execute();
            $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user_data && $user_data['password'] === $pass) {
                $_SESSION['user_id'] = $user_data['id'];
                $_SESSION['username'] = $user_data['username'];

                // Kiểm tra nếu tài khoản là admin
                if ($user_data['username'] === 'admin' && $user_data['password'] === 'admin') {
                    header("Location: admin/indexadmin.php");
                } else {
                    header("Location: index.php");
                }
                exit;
            } else {
                $error_message = "Tên đăng nhập hoặc mật khẩu không đúng.";
            }
        } catch (PDOException $e) {
            die("Lỗi truy vấn: " . $e->getMessage());
        }
    }
}

$conn = null;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
            <h3 class="text-center mb-4">Login</h3>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="text-center mt-3">
                <a href="#" class="text-decoration-none">Forgot your password?</a>
            </div>
        </div>
    </div>
</body>

</html>