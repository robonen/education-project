<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Subject;

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
        $classes = collect([]);
        foreach ($timetables as $timetable) {
            $subjects = collect([]);
            $class = $timetable->schoolClass->only('id','number','letter');
            $forClassTimetables = $timetables->where('class_id', $class['id']);

            foreach ($forClassTimetables as $forClassTimetable) {
                $subjects->push(Subject::find($forClassTimetable['subject_id']));
            }
            $subjects = $subjects->unique()->values();

            $classes->push([
                               'id' => $class['id'],
                               'number' => $class['number'],
                               'letter' => $class['letter'],
                               'subjects' => $subjects,
                           ]);

        }

        return response()->json($classes->unique()->values(), 200);
    }
}
