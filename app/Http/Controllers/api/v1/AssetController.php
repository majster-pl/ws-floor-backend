<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Asset;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssetResource;
use App\Http\Resources\AssetCollection;
use Symfony\Component\HttpFoundation\Response;


class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::where("owner_id", Auth::user()->owner_id)->get()
            ->sortBy('reg');
        return new AssetCollection($assets);
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $data['reg'] = strtoupper($request->reg);
        $data['uuid'] = Str::uuid()->toString();
        $data['owner_id'] = Auth::user()->owner_id;
        $data['created_by'] = Auth::id();
        $new = Asset::create($data);

        return $new;
    }


    public function show($id)
    {
        $asset = Asset::where([['uuid', $id], ['owner_id', Auth::user()
            ->owner_id]])->first();
        if ($asset) {
            return new AssetResource($asset);
        } else {
            $response = ['message' => 'Asset Not Found!'];
            return response()->json(
                $response,
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function update(Request $request, $uuid)
    {
        $asset = Asset::where("uuid", $uuid)->first();
        if ($asset) {
            $asset->update($request->all());
            return new AssetResource($asset);
        } else {
            $response = ['message' => 'Asset Not Found!'];
            return response()->json(
                $response,
                Response::HTTP_NOT_FOUND
            );
        }

    }

    public function destroy($id)
    {
        $asset = Asset::find($id);
        if ($asset) {
            $asset->delete();
            Event::where("asset_id", $id)->delete();
            $response = ['message' => 'Asset removed'];
            return response()->json(
                $response,
                Response::HTTP_OK
            );
        } else {
            $response = ['message' => 'Asset Not Found!'];
            return response()->json(
                $response,
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
