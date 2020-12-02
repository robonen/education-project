<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    /**
     * Получение списка всех учителей
     *
     * @param StudentRequest $request
     * @return JsonResponse
     */
    public function index(StudentRequest $request)
    {
        return response()->json(Student::all(), 200);
    }

    /**
     * Получение одного учителя
     *
     * @param Student $student
     * @param StudentRequest $request
     * @return JsonResponse
     */
    public function show(Student $student, StudentRequest $request)
    {
        return response()->json($student, 200);
    }

    /**
     * Обновление учителя
     *
     * @param StudentRequest $request
     * @param Student $student
     * @return JsonResponse
     */
    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->all());
        return response()->json($student, 200);
    }
}
