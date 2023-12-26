<?php

namespace App\Http\Controllers;

use App\Models\DataDamkar;
use App\Models\DataSensor;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DataSensor::all();
        return view('monitoring.index', compact('data'));
    }

    public function getSensorLocations()
    {
        $sensor_locations = DataSensor::all(['nama', 'tipe_marker', 'latitude', 'longitude']);
        $damkar_locations = DataDamkar::all(['nama', 'tipe_marker', 'latitude', 'longitude']);
        return response()->json(['sensor_locations' => $sensor_locations, 'damkar_locations' => $damkar_locations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Monitoring $monitoring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Monitoring $monitoring)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Monitoring $monitoring)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Monitoring $monitoring)
    {
        //
    }
}
