<?php

use App\Http\Controllers\EspStatusController;
use App\Http\Controllers\LocationTmpController;
use App\Http\Controllers\SensorMonitoringController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::post('/data', function (Request $request) {
//     $dataFromEsp32 = $request->input('data');
//     return response()->json(['message' => 'Hai, From Laravel I ', 'data' => $dataFromEsp32], 200);
// });

Route::controller(SensorMonitoringController::class)->group(function () {
    Route::post('/data', 'update')->name("sensor.update");
});

Route::controller(LocationTmpController::class)->group(function () {
    Route::post('/esp-mode', 'mode');
    Route::post('/save-loc', 'saveLoc');
    Route::post('/update-mode', 'updateMode');
    Route::get('/get-location', 'getLoc');
});
