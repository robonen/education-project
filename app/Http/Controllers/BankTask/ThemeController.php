<?php

namespace App\Http\Controllers\BankTask;


use App\Http\Requests\ThemeRequest;
use App\Models\Theme;
use http\Env\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThemeController extends Controller
{
    /**
     * Получение списка всех тем
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(Theme::all(), 200);
    }

    /**
     * Получение темы
     *
     * @param Theme $theme
     * @return JsonResponse
     */
    public function show(Theme $theme)
    {
        return response()->json($theme, 200);
    }

    /**
     * Создание темы
     *
     * @param ThemeRequest $request
     * @return JsonResponse
     */
    public function store(ThemeRequest $request)
    {
        $theme = Theme::create($request->all());
        return response()->json($theme, 200);
    }

    /**
     * Обновление темы
     *
     * @param Request $request
     * @param Theme $theme
     * @return JsonResponse
     */
    public function update(Theme $theme, Request $request)
    {
        try {
            $theme->update($request->all());
        } catch (QueryException $e) {
            return response()->json('Value can not null', 400);
        }
        return response()->json($theme, 200);
    }

    /**
     * Удаление темы
     *
     * @param Theme $theme
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Theme $theme)
    {
        $theme->delete();
        return response()->json('', 204);

    }
}
