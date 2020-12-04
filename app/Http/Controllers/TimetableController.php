<?php

namespace App\Http\Controllers;

use App\Filters\TimetableFilter;
use App\Http\Requests\TimetableRequest;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimetableController extends Controller
{

    //Получение расписания
    public function index(Request $request)
    {
        $request->validate([
            'date' => 'date_format:Y/m/d',
        ]);
        $builder = Timetable::all()->sortBy('timeStart');
        $timetables = (new TimetableFilter($builder, $request))->apply()->values();
        $answer = [];
        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::parse($request->input('date'))
                ->addDays($i)
                ->format('Y-m-d');
            array_push($answer, [$date => $timetables->where('date', $date)->values()]);
        }
        return response()->json($answer, 200);
    }

     //Получение расписания
    public function show(Timetable $timetable)
    {
        return response()->json($timetable, 200);
    }

    //создание расписания
    public function store(TimetableRequest $request)
    {
        foreach($request->input('timetables') as $timetable) {
            SchoolClass::findOrFail($timetable['class_id']);
            Teacher::findOrFail($timetable['teacher_id']);
            Subject::findOrFail($timetable['subject_id']);
            Timetable::create($timetable);
        }

        return response()->json(['message' => 'Timetable was created'], 201);
    }

    //обновление расписания
    public function update(Timetable $timetable, Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer|gt:0',
            'teacher_id' => 'required|integer|gt:0',
            'subject_id' => 'required|integer|gt:0',
            'date' => 'required|date_format:Y/m/d|',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
        ]);
        SchoolClass::findOrFail($request->input('class_id'));
        Teacher::findOrFail($request->input('teacher_id'));
        Subject::findOrFail($request->input('subject_id'));
        $timetable->update($request->all());
        return response()->json(['message' => 'Timetable was updated'], 200);
    }

    //удаление расписания
    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return response()->json('', 204);
    }
}
