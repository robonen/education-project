<?php

namespace App\Http\Controllers;


use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Получение списка всех предметов
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Subject::all()->sortBy('name'), 200);
    }

    /**
     * Получение предмета
     *
     * @param Subject $subject
     * @return JsonResponse
     */
    public function show(Subject $subject)
    {
        return response()->json($subject, 200);
    }

    /**
     * Создание предмета
     *
     * @param SubjectRequest $request
     * @return JsonResponse
     */
    public function store(SubjectRequest $request)
    {
        $subject = Subject::create($request->all());
        return response()->json($subject, 200);
    }

    /**
     * Обновление предмета
     *
     * @param SubjectRequest $request
     * @param Subject $subject
     * @return JsonResponse
     */
    public function update(Subject $subject, SubjectRequest $request)
    {
        $subject->update($request->all());
        return response()->json($subject, 200);
    }

    /**
     * Удаление предмета
     *
     * @param Subject $subject
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->json('', 204);

    }
}

