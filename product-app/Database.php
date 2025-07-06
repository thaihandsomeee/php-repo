<?php
// Database.php
// Lớp này quản lý kết nối PDO đến cơ sở dữ liệu sử dụng Singleton Pattern.

class Database {
    private static $instance = null; // Biến static để lưu trữ thể hiện duy nhất của lớp Database
    private $pdo; // Biến để lưu trữ đối tượng PDO

    // Constructor là private để ngăn việc tạo đối tượng từ bên ngoài lớp
    private function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Bật chế độ báo lỗi bằng ngoại lệ
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Chế độ fetch mặc định là mảng kết hợp
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Tắt emulate prepares để tăng bảo mật và hiệu suất
        ];
        try {
            // Khởi tạo đối tượng PDO
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Nếu có lỗi kết nối, dừng chương trình và hiển thị thông báo lỗi
            die("Lỗi kết nối database: " . $e->getMessage());
        }
    }

    // Phương thức static để lấy thể hiện duy nhất của lớp Database
    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new Database(); // Nếu chưa có thể hiện, tạo mới
        }
        return self::$instance->pdo; // Trả về đối tượng PDO
    }
}
?>