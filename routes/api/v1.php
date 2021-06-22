<?php

use App\Models\Asset;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\api\v1\AssetController;
use App\Http\Controllers\api\v1\EventController;
use App\Http\Controllers\api\v1\StatsController;
use App\Http\Controllers\api\v1\CustomerController;

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

Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/events', function () {
    //     // return response()->json([Event::all()
    //     // ], Response::HTTP_OK);
    //     return Event::all();
    // });

    // Route::get('/events2', [EventController::class, 'index']);
    Route::apiResource('events', EventController::class);
    Route::apiResource('assets', AssetController::class);
    Route::apiResource('customer', CustomerController::class);
    Route::apiResource('stats', StatsController::class);


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
        return Auth::user();
        // return response()->json([
        //     'logged-in' => 'true', $res
        // ], Response::HTTP_OK);
    });

    Route::fallback(function () {
        return response()->json(['error' => 'Not Found!'], Response::HTTP_NOT_FOUND);
    });
});
