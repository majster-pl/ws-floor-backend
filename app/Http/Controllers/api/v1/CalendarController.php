<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventCollection;

class CalendarController extends Controller
{
    // * Display a listing of Events from date specified and number of days requested.
    // * possible to pass foramt atribute to have data formated differently.
    public function index(Request $request)
    {
        $from = $request->from;
        if ($from === null) {
            return response()->json([
                'error' => [
                    'message' => 'unsupported request, please provide start date [YYYY-MM-DD hh:mm] using `from` argument in request'
                ]
            ]);
        }
        $numberOfDays = $request->days;
        if ($numberOfDays === null) {
            return response()->json([
                'error' => [
                    'message' => 'unsupported request, please provide number of days [int] using `days` argument in request'
                ]
            ]);
        }
        $depot = $request->depot;

        $to = date('Y-m-d h:m', strtotime(date($from) . ' + ' . $request->days . ' days'));
        $events = Event::whereBetween('booked_date_time', [$from, $to])
            ->where([['owning_branch', $depot ? $depot : Auth::user()->default_branch]])
            ->orderBy('events.booked_date_time')
            ->get();

        return new EventCollection($events);
    }
}
