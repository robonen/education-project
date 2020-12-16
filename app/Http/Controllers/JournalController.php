<?php

namespace App\Http\Controllers;

use App\Filters\JournalFilter;
use App\Http\Requests\JournalRequest;
use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $journal = (new JournalFilter(Journal::all(), $request))->apply()->values();
        return response()->json($journal, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param JournalRequest $request
     * @return JsonResponse
     */
    public function store(JournalRequest $request)
    {
        if ($request->has('date'))
            $date = Carbon::createFromTimestamp($request->get('date')/1000)->floorDays();
        else
            $date = Carbon::now()->floorDays();


        $exist = Journal::where('updated_at', $date)
            ->where('student_id', $request->get('student_id'))
            ->where('subject_id', $request->get('subject_id'))
            ->get();

        if ($exist->isNotEmpty())
            return response()->json('Оценка на эту дату уже выставлена', 200);

        $data = array_merge(['updated_at' => $date], $request->all());

        $journal = Journal::create($data);
        return response()->json($journal, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $journal
     * @return JsonResponse
     */
    public function show(int $journal)
    {
        return response()->json(Journal::find($journal), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Journal $journal
     * @return Response
     */
//    public function edit(Journal $journal)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param JournalRequest $request
     * @param Journal $journal
     * @return JsonResponse
     */
    public function update(Request  $request, int $journal)
    {
        $j = Journal::find($journal);
        $j->score = $request->get('score');
        $j->comment = $request->get('comment');
        $j->timestamps = false;
        $j->save();
        return response()->json(['id' => $j->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Journal $journal
     * @return JsonResponse
     */
    public function destroy(Journal $journal)
    {
        $journal->delete();
        return response()->json(null, 200);
    }
}
