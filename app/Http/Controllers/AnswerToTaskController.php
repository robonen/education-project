<?php

namespace App\Http\Controllers;

use App\Models\AnswerToTask;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\TaskFile;

class AnswerToTaskController extends Controller
{
    public function store(Task $task, Request $request) {
        $input = $request->all();
        $input->class_id = $task->class_id;  // Не работает
        $input->student_id = Student::where('user_id', '=', Auth::id())->get(['id']);       // Не работает

        $answer = AnswerToTask::create($input);
        return response()->json($answer, 201);

    }

    public function show(Task $task, Student $student) {
        $answer = AnswerToTask::where([
            ['student_id', '=', $student->id],
            ['task_id', '=', $task->id]
        ])->get();
        $file = TaskFile::where([
            ['student_id', '=', $student->id],
            ['task_id', '=', $task->id]
                                ])
            ->get(['id','name', 'type', 'url']);

        return response()->json([
            'answer' => $answer,
            'files' =>  $file
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
