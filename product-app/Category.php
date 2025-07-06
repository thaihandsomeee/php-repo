<?php
class Category {
    public $id;
    public $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public static function create($name) {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->bindParam(':name', $name);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi khi thêm danh mục: " . $e->getMessage());
            return false;
        }
    }

    public static function getAll() {
        $pdo = Database::getConnection();
        $categories = [];
        try {
            $stmt = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC");
            while ($row = $stmt->fetch()) {
                $categories[] = new Category($row['id'], $row['name']);
            }
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy tất cả danh mục: " . $e->getMessage());
        }
        return $categories;
    }

    public static function getById($id) {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare("SELECT id, name FROM categories WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch();
            if ($row) {
                return new Category($row['id'], $row['name']);
            }
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy danh mục theo ID: " . $e->getMessage());
        }
        return null;
    }

    public static function update($id, $name) {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi khi cập nhật danh mục: " . $e->getMessage());
            return false;
        }
    }

    public static function delete($id) {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi khi xóa danh mục: " . $e->getMessage());
            return false;
        }
    }
}
?>