<?php

use App\Events\SendPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/map', function(Request $request){
    $lat = $request->input('lat');
    $long = $request->input('long');
    $location = [
        "lat" => (float) $lat,
        "lng" => (float) $long
    ];
    event(new SendPosition($location));

    return response()->json([
        'status' => 'success',
        'data' => $location
    ]);
});