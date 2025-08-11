<?php

namespace App\Providers;

namespace App\Providers;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];
    public function boot(): void {
        Gate::define('view-any-tasks', fn(User $user) => $user->role === 'admin');
        Gate::define('view-task', function (User $user, Task $task) {
            return $user->role === 'admin' || $user->id === $task->user_id;
        });
        Gate::define('update-task', function (User $user, Task $task) {
            return $user->id === $task->user_id; // Chỉ chủ sở hữu mới được cập nhật
        });
        Gate::define('delete-task', function (User $user, Task $task) {
            return $user->role === 'admin' || $user->id === $task->user_id;
        });
    }
}
