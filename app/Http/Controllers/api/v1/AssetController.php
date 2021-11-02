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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Asset::where("owner_id", Auth::user()->owner_id)->get()
            ->sortBy('reg');
        return new AssetCollection($assets);
        // return $asset;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $asset = Asset::find($id);
        // $data = $request->all();

        $asset->update($request->all());
        return new AssetResource($asset);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Asset::find($id)->delete();
        Event::where("asset_id", $id)->delete();

        return $asset;
    }
}
