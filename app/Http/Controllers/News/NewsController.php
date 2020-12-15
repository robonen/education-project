<?php

namespace App\Http\Controllers\News;
use App\Http\Controllers\Controller;
use App\Models\NewsFile;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index(Request $request) {
        $count = 5;
        $news = new News;
        if ($request->has('count')) {
            $temp = (int)$request->count;
            if ($temp>0 && $temp<= 100) {
                $count = $temp;
            }
        }

        return response()->json($news->orderByDesc('created_at')->paginate($count), 200);

    }

    public function store(Request $request) {
        // Добавить проверку, после добавление авторизации
        $request->validate([
            'title' => 'required|min:5',
            'description' => 'required',
                           ]);
        $news = News::create($request->all());

        return response()->json($news, 201);
    }

    public function show(News $news) {

        return response()->json([
            $news,
            'photo_id' => NewsFile::where('news_id', '=', $news->id)->get(['id'])
                                    ], 200);
    }

    public function edit(News $news, Request $request) {
        $request->validate([
            'title' => 'required|min:5',
            'description' => 'required'
                           ]);
        $news->update($request->all());

        return response()->json($news, 200);

    }

    public function delete(News $news) {
        $news->delete();

        return response()->json(true, 204);
    }
}
