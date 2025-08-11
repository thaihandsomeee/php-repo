<?php
namespace App\Services;
use App\Models\User;
use App\Repositories\TaskRepository;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService {
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getTasks(User $user, array $filters): Collection
    {
        if (!empty($filters)) {
            return $this->taskRepository->searchAndFilter($filters, $user);
        }
        return $this->taskRepository->getAllForUser($user);
    }

    public function findTaskById(int $taskId, User $user): ?Task
    {
        return $this->taskRepository->findById($taskId, $user);
    }

    public function createNewTask(array $data, User $user): Task
    {
        return $this->taskRepository->create($data, $user->id);
    }

    public function updateTask(Task $task, array $data): bool
    {
        return $this->taskRepository->update($task, $data);
    }

    public function deleteTask(Task $task): ?bool
    {
        return $this->taskRepository->delete($task);
    }
}