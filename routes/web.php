<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RealTimeDataSensor;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataDamkarController;
use App\Http\Controllers\DataSensorController;
use App\Http\Controllers\MonitoringController;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Controllers\SensorMonitoringController;

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


// Route::get('/login', function () {
//     return view('auth.login');
// });
Route::get('/register', function () {
    return view('auth.register');
});


Route::controller(SensorMonitoringController::class)->group(function () {
    Route::get('/monitoring', 'index')->name("monitoring.data");
    Route::get('/data_monitoring', 'data_monitoring')->name("data_monitoring.data");
});

Route::prefix('akun')->controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name("akun");
    Route::get('/add', 'addUser')->name("add_users");
    Route::post('/add', 'store')->name("store_users");
    Route::delete('/delete/{id}', 'destroy')->name("delete_users")->middleware('auth');
});

Route::controller(DataSensorController::class)->group(function () {
    Route::get('/sensor', 'index')->name("sensor.index")->middleware('auth');
    Route::get('/add_sensor', 'create')->middleware('auth');
    Route::get('/sensor_locations', 'sensorLocations')->name("sensor_locations.data");
    // Route::get('/status_sensors', 'statusSensors')->name("status_sensors.data");
    Route::POST('/sensor_store', 'store')->name("sensor.store")->middleware('auth');
    Route::delete('/sensor_delete/{id}', 'destroy')->name("sensor.delete")->middleware('auth');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name("dashboard.data")->name('dashboard')->middleware('auth');
    Route::get('/dashboard', 'index')->name("dashboard.data")->name('dashboard')->middleware('auth');
    // unknown route
    Route::get('/dashboard/show', 'show')->name("dashboard.show")->name('dashboard.show');
});

Route::get('/login', [AuthController::class, 'loginForm'])->name("login")->middleware('guest'); // Form login
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest'); // Login
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth'); // Login

Route::get('/get_data_users', [AuthController::class, 'getUsers']);

Route::controller(RealTimeDataSensor::class)->group(function () {
    Route::get('/real', 'index')->name("real.data");
});

// Route::controller(MonitoringController::class)->group(function () {
//     Route::get('/monitoring', 'index')->name("monitoring.data")->middleware('auth');
//     Route::get('/get-sensor-locations', 'getSensorLocations')->name("get-sensor-locations.data");
// });



Route::controller(DataDamkarController::class)->group(function () {
    Route::get('/damkar', 'index')->name("damkar.index")->middleware('auth');;
    Route::get('/damkar_locations', 'damkarLocations')->name("damkar_locations.data");
    Route::get('/posko/damkar_location', 'poskoDamkarLocation')->name("posko_damkar_location.data");
    Route::get('/add_damkar', 'create')->name("damkar.create")->middleware('auth');
    Route::get('/edit_damkar/{id}', 'show')->name("damkar.show")->middleware('auth');
    Route::POST('/update_damkar', 'update')->name("damkar.update")->middleware('auth');
    Route::POST('/damkar_store', 'store')->name("damkar.store")->middleware('auth');
    Route::delete('/damkar_delete/{id}', 'destroy')->name("damkar.delete")->middleware('auth');
});
