<?php
require_once 'db_config.php';
require_once 'Todo.php';

$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_task'])) {
        $task = trim($_POST['task']);
        if (!empty($task)) {
            if (Todo::addTodo($task)) {
                $message = "Insert success!";
                $message_type = "success";
            } else {
                $message = "Error when insert.";
                $message_type = "error";
            }
        } else {
            $message = "Content not be empty.";
            $message_type = "error";
        }
    }

    if (isset($_POST['update_task'])) {
        $id = (int)$_POST['id']; 
        $task = trim($_POST['task']);

        $completed = isset($_POST['completed']) ? true : false;

        if (!empty($task)) {
            if (Todo::updateTodo($id, $task, $completed)) {
                $message = "Update success!";
                $message_type = "success";
            } else {
                $message = "Error when update.";
                $message_type = "error";
            }
        } else {
            $message = "Content not be empty.";
            $message_type = "error";
        }
    }

    if (isset($_POST['delete_task'])) {
        $id = (int)$_POST['id'];
        if (Todo::deleteTodo($id)) {
            $message = "Delete success!";
            $message_type = "success";
        } else {
            $message = "Error when delete.";
            $message_type = "error";
        }
    }
}

$todos = Todo::getAllTodos();

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
</head>
<body>
    <div>
        <h1>Todo List</h1>

        <?php if ($message):?>
            <div>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="task" placeholder="Thêm công việc mới..." required>
            <button type="submit" name="add_task">Thêm</button>
        </form>

        <ul>
            <?php if (empty($todos)): ?>
                <li>Chưa có công việc nào. Hãy thêm một công việc mới!</li>
            <?php else: ?>
                <?php foreach ($todos as $todo): ?>
                    <li data-id="<?php echo htmlspecialchars($todo->id); ?>">
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($todo->id); ?>">
                            <input type="hidden" name="task" value="<?php echo htmlspecialchars($todo->task); ?>">
                            <input type="checkbox" name="completed"
                                onchange="this.form.submit()" 
                                <?php echo $todo->completed ? 'checked' : ''; ?>>
                            <input type="hidden" name="update_task" value="1">
                        </form>

                        <?php echo htmlspecialchars($todo->task); ?>
                        <?php echo $todo->completed ? '(Đã hoàn thành)' : ''; ?>
                        <span>[ID: <?php echo htmlspecialchars($todo->id); ?>]</span>

                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($todo->id); ?>">
                            <button type="submit" name="delete_task">Xóa</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>