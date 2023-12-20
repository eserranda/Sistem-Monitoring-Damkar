<?php

use App\Models\Monitoring;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RealTimeDataSensor;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataDamkarController;
use App\Http\Controllers\DataSensorController;
use App\Http\Controllers\MonitoringController;

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

Route::get('/monitoring', function () {
    return view('monitoring.index');
});

Route::get('/sensor', function () {
    return view('sensor.index');
});
Route::get('/add_sensor', function () {
    return view('sensor.add');
});

Route::get('/add_sensor', function () {
    return view('sensor.add');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name("dashboard.data");
    Route::get('/', 'index')->name("dashboard.data");
});

Route::controller(RealTimeDataSensor::class)->group(function () {
    Route::get('/real', 'index')->name("real.data");
});

Route::controller(MonitoringController::class)->group(function () {
    Route::get('/get-sensor-locations', 'getSensorLocations')->name("get-sensor-locations.data");
});

Route::controller(DataSensorController::class)->group(function () {
    Route::get('/sensor', 'index')->name("sensor.index");
    Route::get('/sensor_locations', 'sensorLocations')->name("sensor_locations.data");
    Route::POST('/sensor_store', 'store')->name("sensor.store");
    Route::delete('/sensor_delete/{id}', 'destroy')->name("sensor.delete");
});

Route::controller(DataDamkarController::class)->group(function () {
    Route::get('/damkar', 'index')->name("damkar.index");
    Route::get('/damkar_locations', 'damkarLocations')->name("damkar_locations.data");
    Route::get('/add_damkar', 'create')->name("damkar.create");
    Route::POST('/damkar_store', 'store')->name("damkar.store");
    Route::delete('/damkar_delete/{id}', 'destroy')->name("damkar.delete");
});
