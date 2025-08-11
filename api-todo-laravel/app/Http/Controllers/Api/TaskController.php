<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller {
    protected $taskService;
    public function __construct(TaskService $taskService) {
        $this->taskService = $taskService;
    }

    // GET /api/tasks
    public function index(Request $request)
    {
        $filters = $request->only(['completed', 'search']);
        $tasks = $this->taskService->getTasks(Auth::user(), $filters);
        return response()->json($tasks);
    }

    // POST /api/tasks
    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->createNewTask($request->validated(), Auth::user());
        return response()->json($task, 201);
    }

    // GET /api/tasks/{task}
    public function show(Task $task)
    {
        $foundTask = $this->taskService->findTaskById($task->id, Auth::user());

        if (!$foundTask) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        return response()->json($foundTask);
    }

    // PUT/PATCH /api/tasks/{task}
    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update-task', $task);
        $this->taskService->updateTask($task, $request->validated());
        return response()->json($task->fresh());
    }

    // DELETE /api/tasks/{task}
    public function destroy(Task $task)
    {
        Gate::authorize('delete-task', $task);
        $this->taskService->deleteTask($task);
        return response()->json(null, 204);
    }
}