<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function createTask(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|max:100',
            'subject_id' => 'required'
                           ]);

        $add_new = new Task;
        $add_new->name = $request->input('name');
        $add_new->description = $request->input('description');
        $add_new->subject_id = $request->input('subject_id');
        $add_new->path_to_task = $request->input('path_to_task');
        $add_new->save();

        return Task::findOrFail($add_new->id);

    }

    public function index()
    {
        return Task::all(); // Здесь наверное лучше выводить только задания по конкретному предмету
                            // Добавить сортировку
    }

    public function showTask($taskId)
    {
        return Task::where('id', '=', $taskId)->get();
    }

    public function editTask(Task $task, Request $request)
    {
        $request->validate([
            'name' => 'required|min:5:max:100',
            'subject_id' => 'required'
                           ]);

        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->path_to_task = $request->input('path_to_task');

        $task->save();

        return Task::where('id', '=', $task->id)->get();
    }

    public function deleteTask(Task $task)
    {
        $task->delete();

        return 'Task №' . $task->id . ' has been deleted';
    }
}
