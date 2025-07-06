<?php
require_once 'db_config.php';
require_once 'Database.php';
require_once 'User.php';

if (User::isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $message = "Tên đăng nhập và mật khẩu không được để trống.";
        $message_type = "error";
    } else {
        if ($action === 'register') {
            if (User::register($username, $password)) {
                $message = "Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.";
                $message_type = "success";
            } else {
                $message = "Đăng ký thất bại. Tên đăng nhập có thể đã tồn tại.";
                $message_type = "error";
            }
        } elseif ($action === 'login') {
            if (User::login($username, $password)) {
                header('Location: dashboard.php');
                exit();
            } else {
                $message = "Tên đăng nhập hoặc mật khẩu không đúng.";
                $message_type = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập / Đăng ký</title>
</head>
<body>
    <div>
        <h1>Chào mừng đến với Ứng dụng Quản lý Sản phẩm</h1>

        <?php if ($message): ?>
            <div>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <h2>Đăng nhập</h2>
        <form method="POST">
            <input type="hidden" name="action" value="login">
            <label for="login_username">Tên đăng nhập:</label><br>
            <input type="text" id="login_username" name="username" required><br><br>
            <label for="login_password">Mật khẩu:</label><br>
            <input type="password" id="login_password" name="password" required><br><br>
            <button type="submit">Đăng nhập</button>
        </form>

        <hr>

        <h2>Đăng ký</h2>
        <form method="POST">
            <input type="hidden" name="action" value="register">
            <label for="register_username">Tên đăng nhập:</label><br>
            <input type="text" id="register_username" name="username" required><br><br>
            <label for="register_password">Mật khẩu:</label><br>
            <input type="password" id="register_password" name="password" required><br><br>
            <button type="submit">Đăng ký</button>
        </form>
    </div>
</body>
</html>