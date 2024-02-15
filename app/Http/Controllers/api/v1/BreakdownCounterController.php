<?php

namespace App\Http\Controllers\api\v1;

use DateTime;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BreakdownCounterController extends Controller
{
    // Returns number of breakdowns in specified date or current day if null.
    public function index(Request $request)
    {
        $depot = $request->depot;
        $date = $request->date;
        if (!isset($date)) {
            $date = new DateTime();
            $date = $date->format('Y-m-d');
        }

        $events = Event::whereDate('booked_date_time', '=', [$date])
            ->where([
                ['breakdown', 1],
                ['owning_branch', $depot ? $depot : Auth::user()->default_branch]
            ])
            ->orderBy('events.booked_date_time')->get();
        return $events->count();
    }
}
