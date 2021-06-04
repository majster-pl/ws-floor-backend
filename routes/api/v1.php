<?php

use App\Http\Controllers\api\v1\AssetController;
use App\Http\Controllers\api\v1\EventController;
use App\Models\Asset;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group( function () {
    // Route::get('/events', function () {
    //     // return response()->json([Event::all()
    //     // ], Response::HTTP_OK);
    //     return Event::all();
    // });

    // Route::get('/events2', [EventController::class, 'index']);
    Route::apiResource('events', EventController::class);
    Route::apiResource('assets', AssetController::class);
    

    // Route::get('/assets', function () {
    //     // return response()->json([Event::all()
    //     // ], Response::HTTP_OK);
    //     return Asset::all();
    // });
    // Route::get('/assets', function () {
    //     // return response()->json([Event::all()
    //     // ], Response::HTTP_OK);
    //     return Asset::all();
    // });
    
    Route::get('/logged-in', function () {
        return response()->json([
            'logged-in' => 'true',
        ], Response::HTTP_OK);
    });
    
});