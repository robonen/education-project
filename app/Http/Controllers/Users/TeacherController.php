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
use Illuminate\Support\Facades\Response;

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
    //это нужно перенести в update
    public function store(Request $request)
    {
        $path = '/var/www/EducationProject/storage/app/public/users/wd3TZnUTGxZsmIhTpXI4r9NTJIewP8E5MUfdC7u8.png';
        return Response::download($path);
        /*$teacher = Teacher::find(1);
        $path = $request->file('photo')->store('users', 'public');
        $teacher->update($request->all());
        $teacher->photo = $path;
        return response()->json($teacher, 200);*/
    }

    public function destroy(Teacher $teacher)
    {
        $user = $teacher->user;
        $user->delete();
        return response()->json(null, 204);
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
