<?php
class User {
    public $id;
    public $username;
    private $password_hash;

    public function __construct($id, $username, $password_hash = null) {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
    }

    public static function register($username, $password) {
        $pdo = Database::getConnection();
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password_hash', $password_hash);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi đăng ký người dùng: " . $e->getMessage());
            return false;
        }
    }

    public static function login($username, $password) {
        $pdo = Database::getConnection();

        try {
            $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $userRow = $stmt->fetch();

            if ($userRow && password_verify($password, $userRow['password_hash'])) {
                $_SESSION['user_id'] = $userRow['id'];
                $_SESSION['username'] = $userRow['username'];
                return true;
            }
        } catch (PDOException $e) {
            error_log("Lỗi đăng nhập: " . $e->getMessage());
        }
        return false;
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function logout() {
        session_unset();
        session_destroy();
    }

    public static function findByUsername($username) {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $userRow = $stmt->fetch();
            if ($userRow) {
                return new User($userRow['id'], $userRow['username'], $userRow['password_hash']);
            }
        } catch (PDOException $e) {
            error_log("Lỗi tìm người dùng: " . $e->getMessage());
        }
        return null;
    }
}
?>