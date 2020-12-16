<?php

namespace App\Http\Controllers\BankTask;

use App\Http\Requests\BankTaskRequest;
use App\Models\BankTask;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\BankTaskFile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BankTaskController extends Controller
{
    /**
     * Получение списка всех заданий из банка заданий
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request, BankTask $tasks)
    {
        $count = 10;
        $tasks = $tasks->newQuery();

        if ($request->has('name')) {
            $tasks->where('name', 'ilike', $request->input('name').'%');
        }
        if ($request->has('subject_id')) {
            $tasks->where('subject_id', $request->input('subject_id'));
        }
        if ($request->has('theme_id')) {
            $tasks->where('theme_id', $request->input('theme_id'));
        }

        if ($request->has('author')) {
            $tasks->where('author', 'ilike', $request->input('author').'%');
        }

        if ($request->has('count')) {
            $temp = (int)$request->count;
            if ($temp>0 && $temp<= 100) {
                $count = $temp;
            }
        }

        return response()->json($tasks->orderByDesc('updated_at')->paginate($count), 200);
    }

    /**
     * Получение задания
     *
     * @param BankTask $banktask
     * @return JsonResponse
     */
    public function show(BankTask $banktask)
    {

        return response()->json([
            'task' => $banktask,
            'files' => BankTaskFile::where('banktask_id', '=', $banktask->id )->get(['id','name', 'type', 'url'])
        ], 200);

    }

    /**
     * Создание задания
     *
     * @param BankTaskRequest $request
     * @return JsonResponse
     */
    public function store(BankTaskRequest $request)
    {
        if (!Subject::find((int)$request->input('subject_id')) ) {
            return response()->json('Not exist subject', 404);
        }
        $banktask = BankTask::create($request->all()); //добавить auth()->user() после добавления регистрации
        return response()->json($banktask, 200);
    }

    /**
     * Обновление задания
     *
     * @param Request $request
     * @param BankTask $banktask
     * @return JsonResponse
     */
    public function update(BankTask $banktask, Request $request)
    {
        $request->validate([
            'theme_id' => 'nullable|integer|gt:0',
            'subject_id' => 'integer|gt:0',
        ]);
        if ($request->has('subject_id') && !Subject::find((int)$request->input('subject_id'))) {
            return response()->json('Not exist subject', 404);
        }
        $banktask->update($request->all());
        return response()->json($banktask, 200);
    }

    /**
     * Удаление задания
     *
     * @param BankTask $banktask
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(BankTask $banktask)
    {
        $banktask->delete();
        return response()->json('', 204);
    }

}
