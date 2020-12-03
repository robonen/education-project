<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\HeadTeacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HeadTeacherController extends Controller
{
    /**
     * Получение списка всех завучей
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(HeadTeacher::all(), 200);
    }

    /**
     * Получение одного завуча
     *
     * @param HeadTeacher $headteacher
     * @param Request $request
     * @return JsonResponse
     */
    public function show(HeadTeacher $headteacher)
    {
        return response()->json($headteacher, 200);
    }

    /**
     * Обновление завуча
     *
     * @param Request $request
     * @param HeadTeacher $headteacher
     * @return JsonResponse
     */
    public function update(Request $request, HeadTeacher $headteacher)
    {
        $headteacher->update($request->all());
        return response()->json($headteacher, 200);
    }

}
