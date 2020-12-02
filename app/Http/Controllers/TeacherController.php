<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Получение списка всех учителей
     *
     * @param TeacherRequest $request
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Teacher::all(), 200);
    }

    /**
     * Получение одного учителя
     *
     * @param Teacher $teacher
     * @param TeacherRequest $request
     * @return JsonResponse
     */
    public function show(Teacher $teacher)
    {
        return response()->json($teacher, 200);
    }

    /**
     * Обновление учителя
     *
     * @param TeacherRequest $request
     * @param Teacher $teacher
     * @return JsonResponse
     */
    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->all());
        return response()->json($teacher, 200);
    }
}
