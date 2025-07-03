<?php
class Todo {
    public $id;
    public $task;
    public $completed;
    public $created_at;

    public function __construct($id, $task, $completed, $created_at) {
        $this->id = $id;
        $this->task = $task;
        $this->completed = $completed;
        $this->created_at = $created_at;
    }

    public static function getAllTodos() {
        global $pdo;
        $todos = [];

        try {
            $stmt = $pdo->prepare("SELECT id, task, completed, created_at FROM todos ORDER BY id DESC");
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $todos[] = new Todo(
                    $row['id'],
                    $row['task'],
                    (bool)$row['completed'],
                    $row['created_at']
                );
            }
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy tất cả công việc: " . $e->getMessage());
            return [];
        }
        return $todos;
    }

    public static function addTodo($task) {
        global $pdo;
        try {
            $stmt = $pdo->prepare("INSERT INTO todos (task) VALUES (:task)");
            $stmt->bindParam(':task', $task);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi khi thêm công việc: " . $e->getMessage());
            return false;
        }
    }

    public static function updateTodo($id, $task, $completed) {
        global $pdo;
        try {
            $stmt = $pdo->prepare("UPDATE todos SET task = :task, completed = :completed WHERE id = :id");
            $stmt->bindParam(':task', $task);
            $stmt->bindParam(':completed', $completed, PDO::PARAM_BOOL);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi khi cập nhật công việc: " . $e->getMessage());
            return false;
        }
    }

    public static function deleteTodo($id) {
        global $pdo;
        try {
            $stmt = $pdo->prepare("DELETE FROM todos WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi khi xóa công việc: " . $e->getMessage());
            return false;
        }
    }
}

?>
