<?php

namespace App\Http\Controllers;

use App\Models\DataDamkar;
use App\Models\DataSensor;
use Illuminate\Http\Request;
use App\Models\SensorMonitoring;
use Illuminate\Support\Facades\Auth;

class SensorMonitoringController extends Controller
{
    public function data_monitoring()
    {
        $statusSensors = SensorMonitoring::all();
        $sensors = [];
        $apiKeys = [];

        foreach ($statusSensors as $sensor) {
            $selectedSensor = [
                'apiKey' => $sensor->apiKey,
                'sensor_api' => $sensor->sensor_api ? true : null,
                'sensor_gas' => $sensor->sensor_gas ? true : null,
                'sensor_suhu' => $sensor->sensor_suhu ? true : null,
                'sensor_asap' => $sensor->sensor_asap ? true : null,
            ];

            $filteredSensorData = array_filter($selectedSensor, function ($value) {
                return $value === true;
            });

            // Jika 'sensor_api' bernilai 'true', tambahkan 'apiKey' ke daftar unik
            if (!empty($filteredSensorData)) {
                $apiKeys[] = $sensor->apiKey;
                $sensors[] = $filteredSensorData;
            }
        }

        $dataSensor = DataSensor::whereIn('kode_sensor', $apiKeys)->get(['nama', 'status', 'latitude', 'longitude']);

        $id_user = auth()->user()->id;
        $location = DataDamkar::where('id_damkar', $id_user)->get(['latitude', 'longitude', 'nama']);

        return response()->json(['data_sensor' => $dataSensor, 'damkar_location' => $location, 'status_sensor' => $sensors], 200);
    }

    public function index()
    {
        return view('monitoring.index');
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
    public function show(SensorMonitoring $sensorMonitoring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SensorMonitoring $sensorMonitoring)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SensorMonitoring $sensorMonitoring)
    {
        $apiKey = $request->input('apiKey');
        $sensor = $request->input('sensor');
        $data = $request->input('data');

        $allowedColumns = ['sensor_api', 'sensor_gas', 'sensor_suhu', 'sensor_asap'];

        if (!in_array($sensor, $allowedColumns)) {
            return response()->json(['error' => 'Nama Sensor Tidak Sesuai'], 400);
        }

        if ($sensor === "sensor_api" && $data === "0") {
            $data = true;
        }

        $sensorMonitoring->updateOrInsert(
            ['apiKey' => $apiKey],
            [$sensor => $data]
        );

        return response()->json(['success' => true, 'message' => 'Data updated'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SensorMonitoring $sensorMonitoring)
    {
        //
    }
}
