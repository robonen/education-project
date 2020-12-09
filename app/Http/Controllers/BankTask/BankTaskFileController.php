<?php

namespace App\Http\Controllers\BankTask;

use App\Models\BankTask;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\BankTaskFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class BankTaskFileController extends Controller
{
    private $image_ext = ['jpg', 'jpeg', 'png', 'gif'];
    private $file_ext = ['doc', 'docx', 'pdf', 'odt', 'mp3', 'ogg', 'mpga', 'mp4', 'mpeg', 'ppt', 'pptx'];

    public function store(BankTask $banktask, Request $request)
    {
        $banktaskId = $banktask->id;
        $max_size = (int)ini_get('upload_max_filesize') * 1000;
        $all_ext = implode(',', $this->allExtensions());

        $this->validate($request, [
            'name' => 'required',
            'file' => 'required|file|mimes:' . $all_ext . '|max:' . $max_size
        ]);

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $type = $this->getType($ext);

        if (Storage::putFileAs('public/banktask/' . $banktaskId . '/' . $type . '/', $file, $request->name)) {
            BankTaskFile::create([
                'name' => $request->name,
                'type' => $type,
                'extension' => $ext,
                'banktask_id' => $banktaskId,
                'url' => '/storage/banktask' . '/' . $banktaskId . '/' . $type . '/' . $request->name, $file, $request->name . $ext
            ]);
            return true;
        }
        return false;
    }

    public function showFiles(BankTask $banktask)
    {

        $banktaskId = $banktask->id;
        $files = BankTaskFile::where('task_id', '=', $banktaskId)->get();

        return response()->json($files, 200);

    }

    public function download(BankTaskFile $file)
    {
        return Storage::download('/public/banktask/' . $file->banktask_id . '/' . $file->type . '/' . $file->name);
    }

    public function update(BankTaskFile $file, Request $request)
    {

        $request->validate([
            'name' => 'required'
        ]);
        $old_filename = '/public/banktask/' . $file->banktask_id . '/' . $file->type . '/' . $file->name;
        $new_filename = '/public/banktask/' . $file->banktask_id . '/' . $file->type . '/' . $request->name;

        if (Storage::disk('local')->exists($old_filename)) {
            if (Storage::disk('local')->move($old_filename, $new_filename)) {
                $file->name = $request->name;
                $file->url = '/storage/banktask/' . $file->banktask_id . '/' . $request->type . '/' . $file->name;
                return response()->json([$file->save(), $file]);
            }
        }

        return response()->json(false, 404);
    }

    public function delete(BankTaskFile $file) {
        echo $file;
        if (Storage::disk('local')->exists('/public/banktask/' . $file->banktask_id . '/' . $file->type . '/' . $file->name )) {
            if (Storage::disk('local')->delete('/public/banktask/' . $file->banktask_id . '/' . $file->type . '/' . $file->name)) {
                return response()->json($file->delete());
            }
        }
        return response()->json(['BankTaskFile not found'], 404);
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
