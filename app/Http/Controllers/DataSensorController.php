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
        $data = DataSensor::all();
        return view('sensor.index', compact('data'));
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
            'kode_sensor' => 'required|unique:data_sensors',
            'latitude' => 'required|unique:data_sensors',
            'longitude' => 'required|unique:data_sensors',
            'tempat_sensor' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 422);
        }

        $request->merge(['nama' => $request->input('kode_sensor')]);
        $request->merge(['tipe_marker' => 'sensor']);
        DataSensor::create($request->all());
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
    public function destroy($id)
    {
        try {
            $delete = DataSensor::findOrFail($id);
            $delete->delete();

            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}
