<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatLinkRequest;
use App\Models\ChatLink;
use Illuminate\Database\QueryException;

class ChatLinkController extends Controller
{
    //Получение ссылок для класса или для их создателя
    public function index()
    {
        switch(auth()->user()->role->name)
        {
            case 'student':
                $links = ChatLink::all()->where('class_id', auth()->user()->class_id);
                break;

            case 'teacher':
            case 'headteacher':
                $links = auth()->user()->chatLinks;
                break;

            case 'parent':
                $links = [];
                break;
        }

        return response()->json($links, 200);
    }

     //Создание ссылки
    public function store(ChatLinkRequest $request)
    {
        try {
            $link = auth()->user()->create($request->all());
        } catch (QueryException $e) {
            return response()->json(['message'=>'Class not found'], 404);
        }

        return response()->json($link, 201);
    }

     //Обновление ссылки
    public function update(ChatLink $link, ChatLinkRequest $request)
    {
        try {
            $link->update($request->all());
        } catch (QueryException $e) {
            return response()->json(['message'=>'Class not found'], 404);
        }

        return response()->json($link, 200);
    }

     //Удаление ссылки
    public function destroy(ChatLink $link)
    {
        $link->delete();
        return response()->json(null, 204);

    }

}
