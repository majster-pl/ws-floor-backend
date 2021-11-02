<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Asset;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BookingCollection;

class AssetEventHistoryController extends Controller
{
    public function show($uuid)
    {
        $asset_id = Asset::where("uuid", $uuid)->first()->id;
        $events = Event::where([["asset_id", $asset_id], ["status", "completed"], ["owner_id", Auth::user()->id]])->get();
        return new BookingCollection($events);
    }
}
