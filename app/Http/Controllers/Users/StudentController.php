<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use App\Models\AnswerToTask;

class StudentController extends Controller
{
    /**
     * Получение списка всех учеников
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Student::all(), 200);
    }

    /**
     * Получение одного ученика
     *
     * @param Student $student
     * @return JsonResponse
     */
    public function show(Student $student)
    {
        return response()->json($student, 200);
    }

    /**
     * Создание ученика
     *
     * @param StudentRequest $request
     * @return JsonResponse
     */
    /*public function store(StudentRequest $request)
    {
        $student = Student::creat($request->all());
        return response()->json($student, 200);
    }*/

    /**
     * Обновление ученика
     *
     * @param StudentRequest $request
     * @param Student $student
     * @return JsonResponse
     */
    public function update(StudentRequest $request, Student $student)
    {
        $prev_class = $student->schoolClass;
        if ($prev_class) {
            $prev_class->count_students -= 1;
            $prev_class->save();
        }

        $new_class = SchoolClass::findOrfail((int)$request->input('class_id'));
        $student->update($request->all());

        $new_class->count_students++;
        $new_class->save();
        return response()->json(collect($student)->except('school_class'), 200);
    }


    public function destroy(Student $student)
    {
        $user = $student->user;
        $user->delete();
        return response()->json(null, 204);
    }


    public function getAnswers(Student $student) {
        return AnswerToTask::where('student_id', '=', $student->id)->get();
    }

}
