<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolClassRequest;
use App\Models\SchoolClass;
use App\Models\Teacher;
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
    public function addClassroomTeacher(SchoolClass $class, Request $request)
    {
        $teacher = Teacher::findOrfail((int)$request->input('teacher_id'));
        $class->classroom_teacher = $teacher->id;
        $class->save();
        return response()->json(SchoolClass::find($class->id), 200);
    }

}