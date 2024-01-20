<?php

namespace App\Http\Controllers;

use App\Models\DataDamkar;
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
        return view('sensor.add');
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
    public function show(DataSensor $dataSensor, $id)
    {
        $dataSensor = $dataSensor->find($id);
        return view('sensor.edit', compact('dataSensor', 'dataSensor'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function statusSensors()
    {
        $statusSensors = DataSensor::all(['nama', 'status', 'latitude', 'longitude']);
        $id_user = auth()->user()->id;
        $location = DataDamkar::where('id_damkar', $id_user)->get(['latitude', 'longitude']);
        return response()->json(['status' => true, 'data' => $statusSensors, 'location' => $location], 200);
    }

    public function sensorLocations(DataSensor $dataSensor)
    {
        $dataSensor = DataSensor::all();
        return response()->json(['status' => true, 'data' => $dataSensor], 200);
    }

    public function edit(DataSensor $dataSensor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataSensor $dataSensor)
    {
        $validator = Validator::make($request->all(), [
            'kode_sensor' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'tempat_sensor' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 422);
        }

        $request->merge(['nama' => $request->input('kode_sensor')]);
        $request->merge(['tipe_marker' => 'sensor']);

        $dataSensor->where('id', $request->id)->update([
            'kode_sensor' => $request->kode_sensor,
            'nama' => $request->nama,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'tempat_sensor' => $request->tempat_sensor,
            'alamat' => $request->alamat,
        ]);

        return response()->json(['success' => true], 201);
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
