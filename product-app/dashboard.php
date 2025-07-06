<?php
require_once 'db_config.php';
require_once 'Database.php';
require_once 'User.php';
require_once 'Category.php';
require_once 'Product.php';

if (!User::isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$message = '';
$message_type = '';

// Lấy thông báo từ session (sau khi redirect từ chính trang này)
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị
    unset($_SESSION['message_type']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? ''; 

    switch ($action) {
        case 'add_category':
            $categoryName = trim($_POST['category_name'] ?? '');
            if (!empty($categoryName)) {
                if (Category::create($categoryName)) {
                    $_SESSION['message'] = "Thêm danh mục thành công!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Lỗi khi thêm danh mục. Tên có thể đã tồn tại.";
                    $_SESSION['message_type'] = "error";
                }
            } else {
                $_SESSION['message'] = "Tên danh mục không được để trống.";
                $_SESSION['message_type'] = "error";
            }
            break;

        case 'update_category':
            $categoryId = (int)($_POST['category_id'] ?? 0);
            $categoryName = trim($_POST['category_name'] ?? '');
            if ($categoryId > 0 && !empty($categoryName)) {
                if (Category::update($categoryId, $categoryName)) {
                    $_SESSION['message'] = "Cập nhật danh mục thành công!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Lỗi khi cập nhật danh mục.";
                    $_SESSION['message_type'] = "error";
                }
            } else {
                $_SESSION['message'] = "Dữ liệu cập nhật danh mục không hợp lệ.";
                $_SESSION['message_type'] = "error";
            }
            break;

        case 'delete_category':
            $categoryId = (int)($_POST['category_id'] ?? 0);
            if ($categoryId > 0) {
                if (Category::delete($categoryId)) {
                    $_SESSION['message'] = "Xóa danh mục thành công!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Lỗi khi xóa danh mục. Có thể có sản phẩm thuộc danh mục này.";
                    $_SESSION['message_type'] = "error";
                }
            } else {
                $_SESSION['message'] = "ID danh mục không hợp lệ.";
                $_SESSION['message_type'] = "error";
            }
            break;

        case 'add_product':
            $productName = trim($_POST['product_name'] ?? '');
            $productDescription = trim($_POST['product_description'] ?? '');
            $productPrice = (float)($_POST['product_price'] ?? 0);
            $productCategoryId = (int)($_POST['product_category_id'] ?? 0);
            $productCategoryId = $productCategoryId > 0 ? $productCategoryId : null; // Chuyển 0 thành null cho FK

            if (!empty($productName) && $productPrice >= 0) {
                if (Product::create($productName, $productDescription, $productPrice, $productCategoryId)) {
                    $_SESSION['message'] = "Thêm sản phẩm thành công!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Lỗi khi thêm sản phẩm.";
                    $_SESSION['message_type'] = "error";
                }
            } else {
                $_SESSION['message'] = "Tên sản phẩm và giá không được để trống/âm.";
                $_SESSION['message_type'] = "error";
            }
            break;

        case 'update_product':
            $productId = (int)($_POST['product_id'] ?? 0);
            $productName = trim($_POST['product_name'] ?? '');
            $productDescription = trim($_POST['product_description'] ?? '');
            $productPrice = (float)($_POST['product_price'] ?? 0);
            $productCategoryId = (int)($_POST['product_category_id'] ?? 0);
            $productCategoryId = $productCategoryId > 0 ? $productCategoryId : null;

            if ($productId > 0 && !empty($productName) && $productPrice >= 0) {
                if (Product::update($productId, $productName, $productDescription, $productPrice, $productCategoryId)) {
                    $_SESSION['message'] = "Cập nhật sản phẩm thành công!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Lỗi khi cập nhật sản phẩm.";
                    $_SESSION['message_type'] = "error";
                }
            } else {
                $_SESSION['message'] = "Dữ liệu cập nhật sản phẩm không hợp lệ.";
                $_SESSION['message_type'] = "error";
            }
            break;

        case 'delete_product':
            $productId = (int)($_POST['product_id'] ?? 0);
            if ($productId > 0) {
                if (Product::delete($productId)) {
                    $_SESSION['message'] = "Xóa sản phẩm thành công!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Lỗi khi xóa sản phẩm.";
                    $_SESSION['message_type'] = "error";
                }
            } else {
                $_SESSION['message'] = "ID sản phẩm không hợp lệ.";
                $_SESSION['message_type'] = "error";
            }
            break;
    }
    header('Location: dashboard.php');
    exit();
}

$categories = Category::getAll();
$products = Product::getAll();

$editProduct = null;
if (isset($_GET['edit_product_id'])) {
    $editProduct = Product::getById((int)$_GET['edit_product_id']);
    if (!$editProduct) {
        $message = "Không tìm thấy sản phẩm để chỉnh sửa.";
        $message_type = "error";
    }
}

$editCategory = null;
if (isset($_GET['edit_category_id'])) {
    $editCategory = Category::getById((int)$_GET['edit_category_id']);
    if (!$editCategory) {
        $message = "Không tìm thấy danh mục để chỉnh sửa.";
        $message_type = "error";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Quản lý Sản phẩm</title>
</head>
<body>
    <div>
        <h1>Chào mừng, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p><a href="logout.php">Đăng xuất</a></p>

        <?php if ($message): ?>
            <div style="padding: 10px; margin-bottom: 15px; border: 1px solid; background-color: <?php echo ($message_type == 'success' ? '#d4edda' : '#f8d7da'); ?>; color: <?php echo ($message_type == 'success' ? '#155724' : '#721c24'); ?>;">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <hr>

        <h2>Quản lý Danh mục</h2>

        <h3><?php echo $editCategory ? 'Sửa Danh mục' : 'Thêm Danh mục Mới'; ?></h3>
        <form method="POST">
            <input type="hidden" name="action" value="<?php echo $editCategory ? 'update_category' : 'add_category'; ?>">
            <?php if ($editCategory): ?>
                <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($editCategory->id); ?>">
            <?php endif; ?>
            <label for="category_name">Tên danh mục:</label><br>
            <input type="text" id="category_name" name="category_name" value="<?php echo htmlspecialchars($editCategory ? $editCategory->name : ''); ?>" required><br><br>
            <button type="submit"><?php echo $editCategory ? 'Cập nhật Danh mục' : 'Thêm Danh mục'; ?></button>
            <?php if ($editCategory): ?>
                <a href="dashboard.php">Hủy</a>
            <?php endif; ?>
        </form>

        <h3>Danh sách Danh mục</h3>
        <?php if (empty($categories)): ?>
            <p>Chưa có danh mục nào.</p>
        <?php else: ?>
            <table border="1" style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Danh mục</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category->id); ?></td>
                            <td><?php echo htmlspecialchars($category->name); ?></td>
                            <td>
                                <a href="dashboard.php?edit_category_id=<?php echo htmlspecialchars($category->id); ?>">Sửa</a>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete_category">
                                    <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category->id); ?>">
                                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <hr>

        <h2>Quản lý Sản phẩm</h2>

        <h3><?php echo $editProduct ? 'Sửa Sản phẩm' : 'Thêm Sản phẩm Mới'; ?></h3>
        <form method="POST">
            <input type="hidden" name="action" value="<?php echo $editProduct ? 'update_product' : 'add_product'; ?>">
            <?php if ($editProduct): ?>
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($editProduct->id); ?>">
            <?php endif; ?>

            <label for="product_name">Tên sản phẩm:</label><br>
            <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($editProduct ? $editProduct->name : ''); ?>" required><br><br>

            <label for="product_description">Mô tả:</label><br>
            <textarea id="product_description" name="product_description" rows="4" cols="50"><?php echo htmlspecialchars($editProduct ? $editProduct->description : ''); ?></textarea><br><br>

            <label for="product_price">Giá:</label><br>
            <input type="number" id="product_price" name="product_price" step="0.01" value="<?php echo htmlspecialchars($editProduct ? $editProduct->price : ''); ?>" required><br><br>

            <label for="product_category_id">Danh mục:</label><br>
            <select id="product_category_id" name="product_category_id">
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category->id); ?>"
                        <?php echo ($editProduct && $editProduct->category_id == $category->id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category->name); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <button type="submit"><?php echo $editProduct ? 'Cập nhật Sản phẩm' : 'Thêm Sản phẩm'; ?></button>
            <?php if ($editProduct): ?>
                <a href="dashboard.php">Hủy</a>
            <?php endif; ?>
        </form>

        <h3>Danh sách Sản phẩm</h3>
        <?php if (empty($products)): ?>
            <p>Chưa có sản phẩm nào.</p>
        <?php else: ?>
            <table border="1" style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Sản phẩm</th>
                        <th>Mô tả</th>
                        <th>Giá</th>
                        <th>Danh mục</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product->id); ?></td>
                            <td><?php echo htmlspecialchars($product->name); ?></td>
                            <td><?php echo htmlspecialchars(substr($product->description, 0, 50)); ?><?php echo (strlen($product->description) > 50) ? '...' : ''; ?></td>
                            <td><?php echo htmlspecialchars($product->price); ?></td>
                            <td><?php echo htmlspecialchars($product->category_name ?? 'N/A'); ?></td>
                            <td>
                                <a href="dashboard.php?edit_product_id=<?php echo htmlspecialchars($product->id); ?>">Sửa</a>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete_product">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product->id); ?>">
                                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>