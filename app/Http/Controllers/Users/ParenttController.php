<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Parentt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParenttController extends Controller
{
    /**
     * Получение списка всех учителей
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(Parentt::all(), 200);
    }

    /**
     * Получение одного учителя
     *
     * @param Parentt $student
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Parentt $parent)
    {
        return response()->json($parent, 200);
    }

    /**
     * Обновление учителя
     *
     * @param Request $request
     * @param Parentt $parent
     * @return JsonResponse
     */
    public function update(Request $request, Parentt $parent)
    {
        $parent->update($request->all());
        return response()->json($parent, 200);
    }
}
