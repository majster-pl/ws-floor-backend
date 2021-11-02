<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Event;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventCollection;
use App\Http\Resources\BookingCollection;

class CustomerBookingsController extends Controller
{
    public function show($uuid)
    {
        $customer_id = Customer::where("uuid", $uuid)->first()->id;
        $events = Event::where([["customer_id", $customer_id], ["owner_id", Auth::user()->id]])->get();
        return new BookingCollection($events);
    }
}
