<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\TaskFile;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskFileController extends Controller
{
    private $image_ext = ['jpg', 'jpeg', 'png', 'gif'];
    private $file_ext = ['doc', 'docx', 'pdf', 'odt', 'mp3', 'ogg', 'mpga', 'mp4', 'mpeg', 'ppt', 'pptx'];

    public function store(Task $task, Request $request)
    {

        $taskId = $task->id;                        // НАДО ПОДУМАТЬ. СЕЙЧАС РАБОТАЕТ НЕКОРРЕКТНО. НУЖНО СДЕЛАТЬ ТАК ЧТО СИСТЕМА АВТОМАТИЧЕСКИ ОПРЕДЕЛЯЛА К КАКОМУ УЧЕНИКУ ЗАЛИВАТЬ ФАЙЛ УЧИТЕЛЮ
        $studentId = auth()->user()->id;
        $teacherId = auth()->user()->id;
        $max_size = (int)ini_get('upload_max_filesize') * 1000;
        $all_ext = implode(',', $this->allExtensions());
        $this->validate($request, [
            'name' => 'required',
            'file' => 'required|file|mimes:' . $all_ext . '|max:' . $max_size
        ]);

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $type = $this->getType($ext);

        if ($request->has('by_teacher') && (auth()->user()->role_id == 2)) {
            $pathToFile = 'public/task/' . $taskId . '/student/' . $studentId . '/review/' . $type . '/';
            $path = '/storage/task' . '/' . $taskId . '/student/'. $studentId . '/review/' . $type . '/' . $request->name;
            $review = 1;
        } elseif (true) {
            $pathToFile = 'public/task/' . $taskId . '/student/' . $studentId . '/' . $type . '/';
            $path = '/storage/task' . '/' . $taskId . '/student/'. $studentId . '/' . $type . '/' . $request->name;
            $review = 0;
        }


            if (Storage::putFileAs($pathToFile, $file, $request->name)) {
                TaskFile::create(
                    [
                        'name' => $request->name,
                        'type' => $type,
                        'extension' => $ext,
                        'task_id' => $taskId,
                        'url' => $path,
                        'user_id' => $studentId,
                        'review' => $review,
                        $file,
                        $request->name . $ext
                    ]
                );
                return response()->json($request->by_teacher, 201);
            }
        return response()->json(false, 422);
    }

    public function showFiles(Task $task)
    {

        $taskId = $task->id;
        $files = TaskFile::where('task_id', '=', $taskId)->get();

        return response()->json($files, 200);

    }

//    public function download(TaskFile $file)
//    {
//        return Storage::download('/public/task/' . $file->task_id . '/' . $file->type . '/' . $file->name);
//    }

//    public function update(TaskFile $file, Request $request)  Бесполезная функция
//    {
//
//        $request->validate([
//                               'name' => 'required'
//                           ]);
//        $old_filename = '/public/task/' . $file->task_id . '/' . $file->type . '/' . $file->name;
//        $new_filename = '/public/task/' . $file->task_id . '/' . $file->type . '/' . $request->name;
//
//        if (Storage::disk('local')->exists($old_filename)) {
//            if (Storage::disk('local')->move($old_filename, $new_filename)) {
//                $file->name = $request->name;
//                $file->url = '/storage/task/' . $file->task_id . '/' . $request->type . '/' . $file->name;
//                return response()->json([$file->save(), $file]);
//            }
//        }
//
//        return response()->json(false, 404);
//    }

    public function delete(TaskFile $file) {
        $studentId = Student::where('user_id', '=', $file->user_id)->get()->id;
        if (Storage::disk('local')->exists('/public/task/' . $file->task_id . '/student/' . $studentId . $file->type . '/' . $file->name)) {
            if (Storage::disk('local')->delete('/public/task/' . $file->task_id . '/student/' . $studentId . $file->type . '/' . $file->name)) {
                return response()->json($file->delete());
            }
        }
        return response()->json(['Not found'], 404);
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
