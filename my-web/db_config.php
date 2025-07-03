<?php
// db_config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'my-web'); // Tên database của bạn
define('DB_USER', 'root');     // Tên người dùng database
define('DB_PASS', '');     // Mật khẩu người dùng database

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    // Thiết lập chế độ báo lỗi để dễ dàng debug
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Thiết lập chế độ fetch mặc định: trả về mảng kết hợp
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // echo "Kết nối database thành công!"; // Chỉ để kiểm tra
} catch (PDOException $e) {
    die("Lỗi kết nối database: " . $e->getMessage());
}
?>