<?php

namespace App\Http\Controllers;

use App\Models\AnswerToTask;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Models\TaskHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskFile;
use App\Models\Teacher;

class TaskController extends Controller

{
    public function index(Request $request) {

        return Task::where('class_id', '=', $request->class_id);
    }

    public function store(TaskRequest $request) {
        $class = SchoolClass::find(1);
        $teacherId = 1; // Auth()->id();
        $newTask = $class->tasks()->create($request->all() + ['teacher_id' => $teacherId]);


        return response()->json($newTask, 201);
    }

    public function addbanktask(Task $task, Request $request) {
        $temp = new TaskHistory();
        $temp->task_id = $task->id;
        $temp->banktask_id = $request->input('banktask_id');      // Баг - можно впихнуть 2 одинаковых задания из банка задач в один таск

        $temp->save();

            return response()->json($temp, 201);
    }

    public function show(Task $task) {
        $file = TaskFile::where([
            ['task_id', '=', $task->id],
            ['add_by_teacher', '=', '1']
            ])->get(['id', 'name', 'type', 'url', 'user_id']);
        return response()->json([
            'task' => $task,
            'files' => $file

                                ], 200);
    }

    public function delete(Task $task) {
        $task->delete();

        return response()->json(true, 200);
    }

    public function update(Task $task, TaskRequest $request) {
        $request->validate([
                               'name' => 'required|min:5:max:100',
                           ]);
    $task->update($request->all());
//        $task->name = $request->input('name');
//        $task->description = $request->input('description');


        $task->save();

        return Task::where('id', '=', $task->id)->get();
    }

    public function checkAnswer(AnswerToTask $answer, Request $request) {
        $request->validate([
            'mark' => 'required|numeric'
                           ]);

        $answer->comment_by_teacher = $request->input('comment_by_teacher');
        $answer->mark = $request->input('mark');
        $answer->checked = 1;
        $answer->save();

        return response()->json($answer, 200);
    }


}