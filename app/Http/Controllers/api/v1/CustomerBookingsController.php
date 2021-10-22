<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventCollection;
use App\Http\Resources\BookingCollection;

class CustomerBookingsController extends Controller
{
    public function show($id)
    {
        $events = Event::where([["customer_id", $id], ["owner_id", Auth::user()->id]])->get();
        // $events = Event::all();
            return new BookingCollection($events);
        // return $events;
    }
}
