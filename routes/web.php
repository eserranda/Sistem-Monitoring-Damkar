<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard.index');
});
Route::get('/', function () {
    return view('layouts.index');
});

Route::get('/monitoring', function () {
    return view('monitoring.index');
});
Route::get('/sensor', function () {
    return view('sensor.index');
});