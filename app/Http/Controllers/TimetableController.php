<?php

namespace App\Http\Controllers;

use App\Filters\TimetableFilter;
use App\Http\Requests\TimetableRequest;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TimetableController extends Controller
{

    //Получение расписания на неделю
    public function index(Request $request)
    {
        $request->validate([
            'date' => 'date_format:Y/m/d',
        ]);
        $builder = Timetable::all()->sortBy('timeStart');
        $timetables = (new TimetableFilter($builder, $request))->apply()->values();
        $filterTimetables = collect([]);
        foreach ($timetables as $timetable) {
            $subject = $timetable->subject->name;
            $teacher = $timetable->teacher->only('name', 'surname', 'patronymic');
            $class = $timetable->schoolClass->only('number', 'letter');
            $filterTimetables->push([
                'id' => $timetable['id'],
                'date' => $timetable['date'],
                'time_start' => $timetable['time_start'],
                'time_end' => $timetable['time_end'],
                'classroom' => $timetable['classroom'],
                'subject' => $subject,
                'teacher' => $teacher,
                'class' => $class,
            ]);
        }
        $dateTimetables = [];
        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::parse($request->input('date'))
                ->addDays($i)
                ->format('Y-m-d');
            array_push($dateTimetables, [$date => $filterTimetables->where('date', $date)->values()]);
        }
        return response()->json($dateTimetables, 200);
    }

     //Получение урока
    public function show(Timetable $timetable)
    {
        return response()->json($timetable, 200);
    }

    //создание урока
    public function store(TimetableRequest $request)
    {
        try {
            Timetable::create($request->all());
        }catch (QueryException $e) {
            return response()->json(['message' => 'Not found class, teacher or subject'], 400);
        }
        return response()->json(['message' => 'Timetable was created'], 201);
    }

    //обновление урока
    public function update(TimetableRequest $timetable, Request $request)
    {
        try {
            $timetable->update($request->all());
        }catch (QueryException $e) {
            return response()->json(['message' => 'Not found class, teacher or subject'], 400);
        }
        return response()->json(['message' => 'Timetable was updated'], 200);
    }

    //удаление урока
    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return response()->json('', 204);
    }

}
