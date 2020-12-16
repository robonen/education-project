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
        if (!$request->filled('date')) {
            $now = Carbon::now();
            $weekStartDate = $now->startOfWeek()->format('Y-m-d');
            $weekEndDate = Carbon::parse($weekStartDate)
                ->addDays(5)
                ->format('Y-m-d');
            $timetables = $timetables->whereBetween('date', [$weekStartDate, $weekEndDate]);
        }

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
        if (!$filterTimetables->isEmpty()) {
            for ($i = 0; $i < 6; $i++) {
                $date = Carbon::parse($request->input('date'))
                    ->startOfWeek()
                    ->addDays($i)
                    ->format('Y-m-d');
                array_push($dateTimetables, [$date => $filterTimetables->where('date', $date)->values()]);
            }
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
            $timetable = Timetable::create($request->all());
        }catch (QueryException $e) {
            return response()->json(['message' => 'Not found class, teacher or subject'], 400);
        }
        return response()->json($timetable, 201);
    }

    //обновление урока
    public function update(Timetable $timetable, TimetableRequest $request)
    {
        try {
            $timetable->update($request->all());
        }catch (QueryException $e) {
            return response()->json(['message' => 'Not found class, teacher or subject'], 400);
        }
        return response()->json($timetable, 200);
    }

    //удаление урока
    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return response()->json('', 204);
    }

}
