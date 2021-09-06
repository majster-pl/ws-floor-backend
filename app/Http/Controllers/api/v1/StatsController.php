<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatsCollection;
use Symfony\Component\HttpFoundation\Response;

class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $from = $request->from;
        if ($from === null) {
            return response()->json([
                'error' => [
                    'message' => 'unsupported request, please provide start date [YYYY-MM-DD hh:mm] using "from" argument in request'
                ]
            ], Response::HTTP_BAD_REQUEST);
        }
        $numberOfDays = $request->days;
        if ($numberOfDays === null) {
            return response()->json([
                'error' => [
                    'message' => 'unsupported request, please provide number of days [int] using "days" argument in request'
                ]
            ], Response::HTTP_BAD_REQUEST);
        }
        $to = date('Y-m-d 23:59', strtotime(date($from) . ' + ' . $request->days . ' days'));
        $from = date('Y-m-d 00:01', strtotime($from));

        $eventStatus = $request->status;
        if ($eventStatus !== null) {
            $stats = Event::whereBetween('booked_date_time', [$from, $to])
                ->where('status', $eventStatus)
                ->orderBy('events.booked_date_time')
                ->get();
        } else {
            $stats = Event::whereBetween('booked_date_time', [$from, $to])
                ->orderBy('events.booked_date_time')
                ->get();
        }

        return new StatsCollection($stats);
        // return response()->json($from, 200);
        // return response()->json($stats, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Event::all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
