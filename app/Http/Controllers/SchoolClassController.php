<?php

namespace App\Http\Controllers;

use App\Filters\JournalFilter;
use App\Http\Requests\SchoolClassRequest;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Получение списка всех классов
     *
     */
    public function index()
    {
        return response()->json(SchoolClass::all(), 200);
    }

    public function show(SchoolClass $schoolClass)
    {
        return response()->json($schoolClass, 200);
    }

    public function store(SchoolClassRequest $request)
    {
        try {
            $class = SchoolClass::create($request->all());
        } catch (QueryException $e) {
            return response()->json(['message' => 'Уже существует'], 400);
        }
        return response()->json(SchoolClass::find($class->id), 201);
    }

    public function update(SchoolClass $class, SchoolClassRequest $request)
    {
        try {
            $class->update($request->all());
        } catch (QueryException $e) {
            return response()->json(['message' => 'Уже существует'], 400);
        }
        return response()->json($class, 200);
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return response()->json('', 204);
    }

    //добавление, изменение классного руководителя
    public function addTeacher(SchoolClass $class, Request $request)
    {
        $teacher = Teacher::findOrfail((int)$request->input('teacher_id'));
        $class->classroom_teacher = $teacher->id;
        $class->save();
        return response()->json(SchoolClass::find($class->id), 200);
    }

    //получение всех учеников в классе
    public function getStudents(SchoolClass $class)
    {
        $students = $class->students;
        $studentsOnlyFIO = [];
        foreach ($students as $student) {
            array_push($studentsOnlyFIO, $student->only('id', 'name', 'surname', 'patronymic'));
        }
        return response()->json($studentsOnlyFIO, 200);
    }

    public function getStudentsJournal(SchoolClass $class, Request $request)
    {
        $students = $class->students;
        $allStudents = [];

        foreach ($students as $student)
        {
            $cpys = clone $student;
            $cpys->scores = (new JournalFilter($student->scores, $request))->apply()->values();
            $allStudents[] = $cpys;
        }

        return response()->json($allStudents, 200);
    }

    //получение всех предметов для класса
    public function getSubjects(SchoolClass $class)
    {
        $subjects = $class->subjects;
        $subjectExceptPivot = [];
        foreach ($subjects as $subject) {
            array_push($subjectExceptPivot, collect($subject)->except('pivot'));
        }
        return response()->json($subjectExceptPivot, 200);
    }

}
