<?php

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


Route::post('/data1', function (Request $request) {
    $dataFromEsp32 = $request->input('data');
    return response()->json(['message' => 'Hai, From Laravel I ', 'data1' => $dataFromEsp32], 200);
});

Route::post('/data2', function (Request $request) {
    $dataFromEsp32 = $request->input('data');
    return response()->json(['message' => 'Hai, From Laravel II', 'data2' => $dataFromEsp32], 200);
});
