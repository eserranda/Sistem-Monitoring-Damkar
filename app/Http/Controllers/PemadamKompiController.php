<?php

namespace App\Http\Controllers;

use App\Models\DataDamkar;
use App\Models\DataSensor;
use App\Models\SensorMonitoring;
use Illuminate\Http\Request;

class PemadamKompiController extends Controller
{
    public function index()
    {
        return view('monitoring_kebakaran.index');
    }

    function sensorLocations()
    {
        $getDataSensor = DataSensor::where('status', 1)->get();

        if ($getDataSensor->isEmpty()) {
            return response()->json(['status' => 'data not found'], 200);
        }

        return response()->json($getDataSensor);
    }

    function dataDamakrs()
    {
        $dataDamkars = DataDamkar::all();

        if ($dataDamkars->isEmpty()) {
            return response()->json(['status' => 'data not found'], 200);
        }

        return response()->json($dataDamkars);
    }

    public function helper(Request $request)
    {
        $sensor = DataDamkar::where('status', 0)->get();
        return response()->json(['data' => $sensor], 200);
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
