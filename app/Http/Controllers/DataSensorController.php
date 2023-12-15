<?php

namespace App\Http\Controllers;

use App\Models\DataSensor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DataSensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sensor.index');
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
        $validator = Validator::make($request->all(), [
            'kode_sensor' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'tempat_sensor' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DataSensor::created($request->all());
        return response()->json(['success' => true], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(DataSensor $dataSensor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataSensor $dataSensor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataSensor $dataSensor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataSensor $dataSensor)
    {
        //
    }
}