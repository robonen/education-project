<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolClassRequest;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Получение списка всех классов
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(SchoolClass::all(), 200);
    }

    /**
     * Получение класса
     *
     * @param SchoolClass $class
     * @return JsonResponse
     */
    public function show(SchoolClass $class)
    {
        return response()->json($class, 200);
    }

    /**
     * @param SchoolClassRequest $request
     * @return JsonResponse
     */
    public function store(SchoolClassRequest $request)
    {
        $teacher = Teacher::find($request->get('teacher_id'));
        if ($teacher) {
            $schoolClass = $teacher->schoolClass()->create($request->all());
        } else {
            $schoolClass = SchoolClass::create($request->all());
        }
        return response()->json(SchoolClass::find($schoolClass->id), 201);
    }

    /**
     * Обновление класса
     *
     * @param SchoolClassRequest $request
     * @param SchoolClass $class
     * @return JsonResponse
     */
    public function update(SchoolClassRequest $request, SchoolClass $class)
    {
        $class->update($request->all());
        return response()->json($class, 200);
    }


    /**
     * Удаление класса
     *
     * @param SchoolClass $class
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(SchoolClass $class)
    {
        $class->delete();
        return response()->json('ok', 200);
    }
}
