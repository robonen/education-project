<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\AnswerToTask;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Task;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Получение списка всех учителей
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(Teacher::all(), 200);
    }

    /**
     * Получение одного учителя
     *
     * @param Teacher $teacher
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Teacher $teacher, Request $request)
    {
        return response()->json($teacher, 200);
    }

    /**
     * Обновление учителя
     *
     * @param Request $request
     * @param Teacher $teacher
     * @return JsonResponse
     */
    public function update(Request $request, Teacher $teacher)
    {
        $teacher->update($request->all());
        return response()->json($teacher, 200);
    }

    public function getClasses(Teacher $teacher)
    {
        $timetables = $teacher->timetables;
        $classes = [];
        foreach ($timetables as $timetable) {
            array_push($classes, $timetable->schoolClass->only('id','number','letter'));
        }
        return response()->json(collect($classes)->unique(), 200);
    }

    public function getUncheckedTask(Teacher $teacher, SchoolClass $class) {

        $temp = [];
        $tasks = $teacher->tasks->where('class_id', '=', $class->id);
        foreach ($tasks as $task) {
            $answers = Task::find($task->id)->answers->where('checked', '=', false);
            array_push($temp, $answers);
        }
        return response()->json($temp, 200);
    }
}
