<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Asset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerAssetsController extends Controller
{

    public function show($uuid)
    {
        $customer_id = Customer::where("uuid", $uuid)->first()->id;
        $assets = Asset::where([
            ["belongs_to", $customer_id],
            ["owner_id", Auth::user()->owner_id]
        ])->get();
        return $assets;
    }
}
