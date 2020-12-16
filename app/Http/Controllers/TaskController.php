<?php

namespace App\Http\Controllers;

use App\Models\AnswerToTask;
use App\Models\BankTask;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
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
        $tasks = Task::where('class_id', '=', $request->class_id)->get()->sortBy('deadline');
        $temp = [];
        foreach ($tasks as $task) {

            $task->banktask->subject;
            array_push($temp, collect($task)->except(
                                     'banktask.id',
                                          'banktask.description',
                                          'banktask.short_description',
                                          'banktask.theme_id',
                                          'banktask.created_at',
                                          'banktask.updated_at',
                                          'banktask.author',
                                          'banktask.subject.created_at',
                                          'banktask.subject.updated_at',
                                          'banktask.subject_id'
            ));


       }

        return response()->json($temp , 200);
    }

    public function store(TaskRequest $request) {
        $teacherId = auth()->user()->id;
        $banktaskName = BankTask::find($request->banktask_id)->name;
        $banktaskSubject = BankTask::find($request->banktask_id)->subject_id;
        $newTask = Task::create($request->all() + ['teacher_id' => $teacherId
                                       ]);


        return response()->json($newTask, 201);
    }

//    public function addbanktask(Task $task, Request $request) {
//        $temp = new TaskHistory();
//        $temp->task_id = $task->id;
//        $temp->banktask_id = $request->input('banktask_id');      // Баг - можно впихнуть 2 одинаковых задания из банка задач в один таск
//
//        $temp->save();
//
//            return response()->json($temp, 201);
//    }

    public function show(Task $task) {
        $userId = Teacher::find($task->teacher_id)->user_id;

        $file = TaskFile::where('task_id', '=', $task->id)->get(['id', 'name', 'type', 'url', 'user_id']);
        return response()->json([
            $task,
            'files' => $file,



                                ], 200);
    }

    public function delete(Task $task) {
        $task->delete();

        return response()->json(true, 200);
    }

    public function update(Task $task, Request $request) {
        $request->validate([
                               'banktask_id' => 'required|exists:bank_tasks,id',
                           ]);
    $task->update($request->all());


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