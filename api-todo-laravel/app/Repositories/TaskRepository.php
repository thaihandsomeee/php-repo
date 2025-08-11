<?php
namespace App\Repositories;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository {
    public function getAllForUser(User $user): Collection
    {
        if ($user->role === 'admin') {
            return Task::with('user')->latest()->get();
        }
        return $user->tasks()->latest()->get();
    }

    public function findById(int $taskId, User $user): ?Task
    {
        if ($user->role === 'admin') {
            return Task::with('user')->find($taskId);
        }
        return $user->tasks()->find($taskId);
    }

    public function create(array $data, int $userId): Task
    {
        $data['user_id'] = $userId;
        return Task::create($data);
    }

    public function update(Task $task, array $data): bool
    {
        return $task->update($data);
    }

    public function delete(Task $task): ?bool
    {
        return $task->delete();
    }

    public function searchAndFilter(array $filters, User $user): Collection
    {
        $query = ($user->role === 'admin') ? Task::query()->with('user') : $user->tasks();

        if (isset($filters['completed'])) {
            $status = filter_var($filters['completed'], FILTER_VALIDATE_BOOLEAN);
            $query->where('completed', $status);
        }

        if (isset($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->get();
    }
}
