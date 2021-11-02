<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssetResource;
use App\Models\Customer;

class CustomerAssetsController extends Controller
{

    public function show($id)
    {
        $asset_id = Customer::where("uuid", $id)->first()->id;
        $assets = Asset::where([["belongs_to", $asset_id], ["owner_id", Auth::user()->id]])->get();
        return $assets;
    }
}
