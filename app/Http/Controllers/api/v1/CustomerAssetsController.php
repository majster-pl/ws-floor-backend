<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssetResource;

class CustomerAssetsController extends Controller
{

    public function show($id)
    {
        $assets = Asset::where([["belongs_to", $id],["owner_id", Auth::user()->id]])->get();
        // $assets = Asset::where([["belongs_to", $id]])->get();
        return $assets;
    }

}
