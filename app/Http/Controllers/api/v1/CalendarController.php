<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventCollection;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $from = $request->from;
        if ($from === null) {
            return response()->json([
                'error' => [
                    'message' => 'unsupported request, please provide start date 
                    [YYYY-MM-DD hh:mm] using "from" argument in request'
                ]
            ]);
        }
        $numberOfDays = $request->days;
        if ($numberOfDays === null) {
            return response()->json([
                'error' => [
                    'message' => 'unsupported request, please provide number 
                    of days [int] using "days" argument in request'
                ]
            ]);
        }
        $depot = $request->depot;

        $to = date('Y-m-d h:m', strtotime(date($from) . ' + ' . $request->days . ' days'));
        // $events = Event::withTrashed()->whereBetween('booked_date', [$from, $to])
        //     ->orderBy('events.booked_date_time')
        //     ->get();
        $events = Event::whereBetween('booked_date_time', [$from, $to])
            ->where([['owning_branch', $depot ? $depot : Auth::user()->default_branch]])
            ->orderBy('events.booked_date_time')
            ->get();

        return new EventCollection($events);
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
