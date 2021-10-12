<?php

use App\Models\Asset;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\api\v1\AssetController;
use App\Http\Controllers\api\v1\CompanyController;
use App\Http\Controllers\api\v1\DepotController;
use App\Http\Controllers\api\v1\EventController;
use App\Http\Controllers\api\v1\StatsController;
use App\Http\Controllers\api\v1\CustomerController;
use App\Http\Controllers\api\v1\WorkshopController;
use App\Models\Company;

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
    Route::apiResource('assets', AssetController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('events', EventController::class);
    Route::apiResource('workshop', WorkshopController::class);
    Route::apiResource('stats', StatsController::class);
    Route::apiResource('depot', DepotController::class);
    Route::apiResource('company', CompanyController::class);


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
        // return Auth::user();
        $user = Auth::user();
        $user["logged-in"] = true;
        $company = Company::where('id', $user->owner_id)->get();
        $user["company"] = $company[0]->name;
        return response()->json(
            $user,
            Response::HTTP_OK
        );
    });

    Route::fallback(function () {
        return response()->json(['error' => 'Not Found!'], Response::HTTP_NOT_FOUND);
    });
});
