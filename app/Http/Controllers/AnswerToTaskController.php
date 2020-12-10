<?php

namespace App\Http\Controllers;

use App\Models\AnswerToTask;
use App\Models\BankTask;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\TaskFile;

class AnswerToTaskController extends Controller
{
    public function store(Task $task, Request $request) {
        $input = $request->all();


        $answer = AnswerToTask::create($input+ ['task_id' =>  $task->id,
                                           'student_id' => 1]);
        return response()->json($answer, 201);

    }

    public function show(Task $task, Student $student) {
        $name = BankTask::find($task->banktask_id)->name;

        $answer = AnswerToTask::where([
            ['student_id', '=', $student->id],
            ['task_id', '=', $task->id]
        ])->get();
        $answer->name = $name;
        $answer->deadline = $task->deadline;
        $studentFile = TaskFile::where([
            ['user_id', '=', '2'], // Auth::id()
            ['task_id', '=', $task->id]
                                ])
            ->get(['id','name', 'type', 'url']);
        $teacherFile = TaskFile::where([
            ['user_id', '=', '2'], // Auth::id()
            ['task_id', '=', $task->id],
            ['review', '=', 1]
                                       ])
            ->get(['id','name', 'type', 'url']);

        return response()->json([
            'answer' => $answer,
            'files' =>  [
                'student' => $studentFile,
                'teacher' => $teacherFile
            ]
        ],200);
    }

    public function delete(AnswerToTask $answer){
        $answer->delete();

        return response()->json(true, 204);
    }

    public function update(AnswerToTask $answer, Request $request) {
        $answer->description = $request->input('description');
        $answer->save();

        return $answer;

    }

}
