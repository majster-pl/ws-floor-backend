<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BookingCollection;
use App\Models\Asset;

class AssetEventActiveController extends Controller
{
    public function show($uuid)
    {
        $asset_id = Asset::where("uuid", $uuid)->first()->id;
        $events = Event::where(
            [
                ["asset_id", $asset_id], 
                ["status", "!=", "completed"], 
                ["owner_id", Auth::user()->owner_id]
            ]
            )->withTrashed()->get();
        return new BookingCollection($events);
    }
}
