<!-- GET -->
<!-- <form action="index2.php" method="GET">
    <label for="name">Tên của bạn:</label>
    <input type="text" id="name" name="userName"><br><br>
    <input type="submit" value="GET">
</form> -->

<!-- POST -->
<!-- <form action="index2.php" method="POST">
    <label for="email">Email:</label>
    <input type="email" id="email" name="userEmail"><br><br>
    <label for="password">Mật khẩu:</label>
    <input type="password" id="password" name="userPassword"><br><br>
    <input type="submit" value="POST">
</form> -->

<!-- <form method="POST">
    <h3>Thêm người dùng</h3>
    Tên: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    <button type="submit" name="add_user">Thêm</button>
</form>  -->

<!-- <form method="GET">
    <h3>Tìm người dùng theo ID</h3>
    ID: <input type="number" name="user_id" required><br>
    <button type="submit">Tìm</button>
</form> -->

<!-- <form method="POST">
    <h3>Cập nhật người dùng</h3>
    ID người dùng cần cập nhật: <input type="number" name="id" required><br>
    Tên mới: <input type="text" name="name" required><br>
    Email mới: <input type="email" name="email" required><br>
    <button type="submit" name="update_user">Cập nhật</button>
</form> -->

<form method="POST">
    <h3>Xóa người dùng</h3>
    ID người dùng cần xóa: <input type="number" name="id" required><br>
    <button type="submit" name="delete_user">Xóa</button>
</form>

<?php
//GET
// if (isset($_GET['userName'])) {
//     $userName = $_GET['userName'];
//     echo "Chào mừng, " . htmlspecialchars($userName) . "!";
// } else {
//     echo "Không có tên được gửi.";
// }

// POST
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (isset($_POST['userEmail']) && isset($_POST['userPassword'])) {
//         $email = $_POST['userEmail'];
//         $password = $_POST['userPassword']; // Lưu ý: Không lưu mật khẩu thô!

//         echo "Email: " . htmlspecialchars($email) . "<br>";
//         echo "Mật khẩu (không nên hiển thị trực tiếp): " . htmlspecialchars($password) . "<br>";
//     } else {
//         echo "Thiếu thông tin email hoặc mật khẩu.";
//     }
// } else {
//     echo "Yêu cầu không hợp lệ.";
// }


// CREATE TABLE
// $message = '';
// $message_type = '';

// $sql = "
//     CREATE TABLE IF NOT EXISTS users (
//         id INT AUTO_INCREMENT PRIMARY KEY,
//         name VARCHAR(255) NOT NULL,
//         email VARCHAR(255) NOT NULL UNIQUE,
//         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//     );";

// try {
//     // Sử dụng exec() cho các câu lệnh SQL không trả về tập hợp kết quả (như CREATE, ALTER, DROP)
//     $pdo->exec($sql);
//     $message = "Bảng 'users' đã được tạo thành công hoặc đã tồn tại.";
//     $message_type = "success";
// } catch (PDOException $e) {
//     $message = "Lỗi khi tạo bảng: " . $e->getMessage();
//     $message_type = "error";
// }

// if ($message) {
//     echo "<div class='message " . $message_type . "'>" . htmlspecialchars($message) . "</div>";
// }

include 'db_config.php';

// CREATE 
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
//     $name = $_POST['name'];
//     $email = $_POST['email'];

//     try {
//         $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
//         // Gán giá trị vào các placeholder
//         $stmt->bindParam(':name', $name);
//         $stmt->bindParam(':email', $email);
//         $stmt->execute();

//         echo "Thêm người dùng thành công! ID: " . $pdo->lastInsertId() . "<br>";
//     } catch (PDOException $e) {
//         echo "Lỗi thêm người dùng: " . $e->getMessage() . "<br>";
//     }
// }

// SELECT
// try {
//     $stmt = $pdo->query("SELECT * FROM users");
//     $users = $stmt->fetchAll(); // Lấy tất cả kết quả

//     echo "<h3>Danh sách người dùng</h3>";
//     if (count($users) > 0) {
//         echo "<table border='1'>";
//         echo "<tr><th>ID</th><th>Tên</th><th>Email</th><th>Ngày tạo</th></tr>";
//         foreach ($users as $user) {
//             echo "<tr>";
//             echo "<td>" . htmlspecialchars($user['id']) . "</td>";
//             echo "<td>" . htmlspecialchars($user['name']) . "</td>";
//             echo "<td>" . htmlspecialchars($user['email']) . "</td>";
//             echo "<td>" . htmlspecialchars($user['created_at']) . "</td>";
//             echo "</tr>";
//         }
//         echo "</table>";
//     } else {
//         echo "Không có người dùng nào.";
//     }
// } catch (PDOException $e) {
//     echo "Lỗi đọc dữ liệu: " . $e->getMessage() . "<br>";
// }

// if (isset($_GET['user_id'])) {
//     $userId = $_GET['user_id'];
//     try {
//         $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
//         $stmt->bindParam(':id', $userId, PDO::PARAM_INT); // Chỉ định kiểu dữ liệu là INT
//         $stmt->execute();
//         $user = $stmt->fetch(); // Lấy một kết quả

//         echo "<h3>Thông tin người dùng (ID: " . htmlspecialchars($userId) . ")</h3>";
//         if ($user) {
//             echo "Tên: " . htmlspecialchars($user['name']) . "<br>";
//             echo "Email: " . htmlspecialchars($user['email']) . "<br>";
//         } else {
//             echo "Không tìm thấy người dùng có ID " . htmlspecialchars($userId) . ".<br>";
//         }
//     } catch (PDOException $e) {
//         echo "Lỗi truy vấn: " . $e->getMessage() . "<br>";
//     }
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
//     $id = $_POST['id'];
//     $name = $_POST['name'];
//     $email = $_POST['email'];

//     try {
//         $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
//         $stmt->bindParam(':name', $name);
//         $stmt->bindParam(':email', $email);
//         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
//         $stmt->execute();

//         echo "Cập nhật người dùng ID " . htmlspecialchars($id) . " thành công! Số dòng ảnh hưởng: " . $stmt->rowCount() . "<br>";
//     } catch (PDOException $e) {
//         echo "Lỗi cập nhật người dùng: " . $e->getMessage() . "<br>";
//     }
// }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $id = $_POST['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo "Xóa người dùng ID " . htmlspecialchars($id) . " thành công! Số dòng ảnh hưởng: " . $stmt->rowCount() . "<br>";
    } catch (PDOException $e) {
        echo "Lỗi xóa người dùng: " . $e->getMessage() . "<br>";
    }
}
?>
