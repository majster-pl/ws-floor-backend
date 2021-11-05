<?php

use App\Models\Asset;
use App\Models\Event;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\AssetController;
use App\Http\Controllers\api\v1\DepotController;
use App\Http\Controllers\api\v1\EventController;
use App\Http\Controllers\api\v1\StatsController;
use App\Http\Controllers\api\v1\CompanyController;
use App\Http\Controllers\api\v1\CalendarController;
use App\Http\Controllers\api\v1\CustomerController;
use App\Http\Controllers\api\v1\WorkshopController;
use App\Http\Controllers\api\v1\EventUuidController;
use App\Http\Controllers\api\v1\AssetHistoryController;
use App\Http\Controllers\api\v1\CustomerAssetsController;
use App\Http\Controllers\api\v1\AssetEventActiveController;
use App\Http\Controllers\api\v1\BreakdownCounterController;
use App\Http\Controllers\api\v1\CustomerBookingsController;
use App\Http\Controllers\api\v1\AssetEventHistoryController;

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
    Route::apiResource('event_uuid', EventUuidController::class);
    Route::apiResource('workshop', WorkshopController::class);
    Route::apiResource('stats', StatsController::class);
    Route::apiResource('depot', DepotController::class);
    Route::apiResource('company', CompanyController::class);
    Route::apiResource('calendar', CalendarController::class);
    Route::apiResource('breakdown', BreakdownCounterController::class);
    Route::apiResource('customer_assets', CustomerAssetsController::class);
    Route::apiResource('customer_bookings', CustomerBookingsController::class);
    Route::apiResource('asset_event_history', AssetEventHistoryController::class);
    Route::apiResource('asset_event_active', AssetEventActiveController::class);
    Route::apiResource('user', UserController::class);


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
