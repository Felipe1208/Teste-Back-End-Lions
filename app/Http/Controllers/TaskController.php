<?php

namespace App\Http\Controllers;

use App\Events\TaskCreated;
use App\Http\Requests\CreateTaskRequest;
use Illuminate\Support\Facades\Queue;
use App\Jobs\SendTaskCreatedEmail;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function listTasks(Request $request)
    {
        $query = Task::select('tasks.*', 'categories.name as category_name')
            ->leftJoin('categories', 'categories.id', '=', 'tasks.category_id');

        if ($request->has('title')) {
            $title = $request->input('title');
            $query->where('tasks.title', 'like', '%' . $title . '%');
        }

        $tasks = $query->get();

        return response()->json(['data' => $tasks], 200);
    }

    public function searchTaskById($id)
    {
        try {
            $task = Task::findOrFail($id);

            return response()->json(['data' => $task], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task não encontrada.'], 404);
        }
    }

    public function createTask(CreateTaskRequest $request)
    {
        $task = Task::create([
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
        ]);

        event(new TaskCreated($task));

        return response()->json(['message' => 'Task criada com sucesso!', 'data' => $task], 201);
    }

    public function updateTask(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            $task->fill($request->only(['title', 'description', 'category_id', 'completed']));

            $task->save();

            return response()->json(['message' => 'Task atualizada com sucesso!', $task], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task não encontrada.'], 404);
        }
    }

    public function completeTask($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada.'], 404);
        }

        if ($task->completed == 1) {
            return response()->json(['message' => 'A tarefa já está completa.'], 400);
        }

        $task->completed = 1;
        $task->save();

        return response()->json(['message' => 'Ok.'], 200);
    }

    public function deleteTask($id)
    {
        try {
            $task = Task::findOrFail($id);

            $task->delete();

            return response()->json(['message' => 'Task apagada com sucesso!'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Task não encontrada.'], 404);
        }
    }
}
