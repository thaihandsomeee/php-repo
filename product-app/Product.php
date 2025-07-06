<?php
class Product {
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;

    public function __construct($id, $name, $description, $price, $category_id, $category_name = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category_id = $category_id;
        $this->category_name = $category_name;
    }

    public static function create($name, $description, $price, $categoryId) {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, description, price, category_id) VALUES (:name, :description, :price, :category_id)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi khi thêm sản phẩm: " . $e->getMessage());
            return false;
        }
    }

    public static function getAll() {
        $pdo = Database::getConnection();
        $products = [];
        try {
            $sql = "SELECT p.id, p.name, p.description, p.price, p.category_id, c.name AS category_name
                    FROM products p
                    LEFT JOIN categories c ON p.category_id = c.id
                    ORDER BY p.id DESC";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch()) {
                $products[] = new Product(
                    $row['id'],
                    $row['name'],
                    $row['description'],
                    $row['price'],
                    $row['category_id'],
                    $row['category_name']
                );
            }
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy tất cả sản phẩm: " . $e->getMessage());
        }
        return $products;
    }

    public static function getById($id) {
        $pdo = Database::getConnection();
        try {
            $sql = "SELECT p.id, p.name, p.description, p.price, p.category_id, c.name AS category_name
                    FROM products p
                    LEFT JOIN categories c ON p.category_id = c.id
                    WHERE p.id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch();
            if ($row) {
                return new Product(
                    $row['id'],
                    $row['name'],
                    $row['description'],
                    $row['price'],
                    $row['category_id'],
                    $row['category_name']
                );
            }
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy sản phẩm theo ID: " . $e->getMessage());
        }
        return null;
    }

    public static function update($id, $name, $description, $price, $categoryId) {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare("UPDATE products SET name = :name, description = :description, price = :price, category_id = :category_id WHERE id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi khi cập nhật sản phẩm: " . $e->getMessage());
            return false;
        }
    }

    public static function delete($id) {
        $pdo = Database::getConnection(); // Lấy kết nối PDO
        try {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi khi xóa sản phẩm: " . $e->getMessage());
            return false;
        }
    }
}
?>