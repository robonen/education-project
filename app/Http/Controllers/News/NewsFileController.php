<?php

namespace App\Http\Controllers\News;

use App\Models\NewsFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\News;


class NewsFileController extends Controller

{
    private $image_ext = ['jpg', 'jpeg', 'png', 'gif'];
    private $file_ext = ['doc', 'docx', 'pdf', 'odt', 'mp3', 'ogg', 'mpga', 'mp4', 'mpeg', 'ppt', 'pptx'];

    public function store(News $news, Request $request)
    {
        $newsId = $news->id;
        $max_size = (int)ini_get('upload_max_filesize') * 1000;
        $all_ext = implode(',', $this->allExtensions());

        $this->validate($request, [
            'name' => 'required',
            'file' => 'required|file|mimes:' . $all_ext . '|max:' . $max_size
        ]);

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $type = $this->getType($ext);

        if (Storage::putFileAs('public/news/' . $newsId . '/' . $type . '/', $file, $request->name)) {
            NewsFile::create([
                                     'name' => $request->name,
                                     'type' => $type,
                                     'extension' => $ext,
                                     'news_id' => $newsId,
                                      $file,
                                      $request->name . $ext
                                 ]);
            $news->photo_uri = '/storage/news' . '/' . $newsId . '/' . $type . '/' . $request->name;
            return true;
        }
        return false;
    }





    public function delete(NewsFile $file) {

        if (Storage::disk('local')->exists('/public/news/' . $file->news_id . '/' . $file->type . '/' . $file->name )) {
            if (Storage::disk('local')->delete('/public/news/' . $file->news_id . '/' . $file->type . '/' . $file->name)) {
                return response()->json($file->delete(), 204);
            }
        }
        return response()->json(['News not found'], 404);
    }


    private function getType($ext)
    {
        if (in_array(strtolower($ext), $this->image_ext)) {
            return 'image';
        }

        if (in_array(strtolower($ext), $this->file_ext)) {
            return 'file';
        }
    }

    private function allExtensions()
    {
        return array_merge($this->image_ext, $this->file_ext);
    }



}
