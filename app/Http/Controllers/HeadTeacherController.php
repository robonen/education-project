<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeadTeacherRequest;
use App\Models\HeadTeacher;
use Illuminate\Http\JsonResponse;

class HeadTeacherController extends Controller
{
    /**
     * Получение списка всех завучей
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(HeadTeacher::all(), 200);
    }

    /**
     * Получение одного завуча
     *
     * @param HeadTeacher $headteacher
     * @return JsonResponse
     */
    public function show(HeadTeacher $headteacher)
    {
        return response()->json($headteacher, 200);
    }

    /**
     * Обновление завуча
     *
     * @param HeadTeacherRequest $request
     * @param HeadTeacher $headteacher
     * @return JsonResponse
     */
    public function update(HeadTeacherRequest $request, HeadTeacher $headteacher)
    {
        $headteacher->update($request->all());
        return response()->json($headteacher, 200);
    }

}
