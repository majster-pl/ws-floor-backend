<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BookingCollection;

class AssetEventActiveController extends Controller
{
    public function show($id)
    {
        $events = Event::where([["asset_id", $id], ["status", "!=", "completed"], ["owner_id", Auth::user()->id]])->get();
        return new BookingCollection($events);
    }
}
