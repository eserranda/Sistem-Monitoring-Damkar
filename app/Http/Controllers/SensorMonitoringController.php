<?php

namespace App\Http\Controllers;

use App\Models\DataDamkar;
use App\Models\DataSensor;
use Illuminate\Http\Request;
use App\Models\SensorMonitoring;
use Illuminate\Support\Facades\Auth;

class SensorMonitoringController extends Controller
{

    public function damkarSelected($id)
    {
        DataDamkar::where('id', $id)->update(['status' => 1, 'helper' => 1]);

        $location = DataDamkar::where('id', $id)->get(['latitude', 'longitude', 'nama']);

        if ($location) {
            return response()->json(['message' => 'success', 'status' => true], 200);
        } else {
            return response()->json(['message' => 'Failed', 'status' => false], 400);
        }
    }

    public function helper($id)
    {
        $sensor = DataDamkar::where('id_damkar', '!=', $id)->where('status', 0)->get();
        return response()->json(['data' => $sensor], 200);
    }


    protected  function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // Radius bumi dalam kilometer

        $dlat = deg2rad($lat2 - $lat1);
        $dlon = deg2rad($lon2 - $lon1);

        $a = sin($dlat / 2) * sin($dlat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $R * $c; // Jarak dalam kilometer

        return $distance;
    }

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

        DataSensor::whereIn('kode_sensor', $apiKeys)->update(['status' => 1]);

        $dataSensor = DataSensor::where('kode_sensor', $apiKeys)
            ->where('status', 1)
            ->get(['nama', 'status', 'latitude', 'longitude']);
        // cari damkar terdekat
        $latitudeSensor = $dataSensor->pluck('latitude')->toArray();
        $longitudeSensor = $dataSensor->pluck('longitude')->toArray();

        $damkars = DataDamkar::all(['id_damkar', 'latitude', 'longitude']);
        // $damkars = DataDamkar::where('status', 0)->get(['id_damkar', 'latitude', 'longitude']);

        // $jumlah_damkar = count($damkars);
        // dd($jumlah_damkar);

        // if ($jumlah_damkar == 1) {
        //     $damkars = DataDamkar::where('status', 0)->get(['id_damkar', 'latitude', 'longitude']);
        //     return response()->json(['data_sensor' => $dataSensor, 'damkar_location' => $damkars, 'status_sensor' => $sensors], 200);
        // } else {
        $minDistance = PHP_INT_MAX;
        $nearestDamkarId = null;

        // $damkars = DataDamkar::where('status', 0)->get(['id_damkar', 'latitude', 'longitude']);
        foreach ($damkars as $damkar) {
            $distance = $this->haversine($latitudeSensor[0], $longitudeSensor[0], $damkar->latitude, $damkar->longitude);

            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearestDamkarId = $damkar->id_damkar;
            }
        }
        $id_user = auth()->user()->id; // id user yang login

        $location = DataDamkar::where('id_damkar', $nearestDamkarId)->get(['latitude', 'longitude', 'nama']);

        DataDamkar::where('id_damkar', $nearestDamkarId)->update(['status' => 1]);
        if ($id_user == $nearestDamkarId) {
            return response()->json(['data_sensor' => $dataSensor, 'damkar_location' => $location, 'status_sensor' => $sensors], 200);
        } else {
            $helperLocation = DataDamkar::where('helper', 1)->get(['latitude', 'longitude', 'nama']);

            return response()->json(['data_sensor' => $dataSensor, 'damkar_location' => $helperLocation, 'status_sensor' => $sensors], 200);

            // return response()->json(['status_sensor' => $location], 200);
        }
        // }
        // if (auth()->user()->id == $nearestDamkarId) {
        //     dd("data sama");
        // } else {
        //     dd("data berbeda");
        // }

        // if ($nearestDamkarId !== null && $nearestDamkarId === $id_user) {
        //     $location = DataDamkar::where([
        //         'id_damkar' => $id_user,
        //         'status' => 0
        //     ])->first(['latitude', 'longitude', 'nama']);

        //     DataDamkar::where([
        //         'id_damkar' => $id_user,
        //     ])->update(['status' => 1]);
        // } else if ($nearestDamkarId !== null) {
        //     $location = DataDamkar::where([
        //         'id_damkar' => $id_user,
        //         // 'status' => 0
        //     ])->first(['latitude', 'longitude', 'nama']);
        // }


        // $location = DataDamkar::where(function ($query) use ($nearestDamkarId, $id_user) {
        //     $query->where('id_damkar', $nearestDamkarId)
        //         ->orWhere('id_damkar', $id_user);
        // })->where('status', 0)->first(['latitude', 'longitude', 'nama']);

        //end rumus mencari damkar terdekat

        // return response()->json(['data_sensor' => $dataSensor, 'damkar_location' => $location, 'status_sensor' => $sensors], 200);
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

    // public function resetNilai(Request $request)
    // {
    //     $apiKey = $request->input('apiKey');
    //     $resetData = SensorMonitoring::where('apiKey', $apiKey)->update(['sensor_api' => 0, 'sensor_gas' => 0, 'sensor_suhu' => 0, 'sensor_asap' => 0]);
    //     if ($resetData) {
    //         return response()->json(['message' => 'success'], 200);
    //     } else {
    //         return response()->json(['message' => 'Failed'], 400);
    //     }
    // }

    public function resetStatus(Request $request)
    {
        $apiKey = $request->input('apiKey');
        $damkar = $request->input('damkar');

        SensorMonitoring::where('apiKey', $apiKey)->update(['sensor_api' => 0, 'sensor_gas' => 0, 'sensor_suhu' => 0, 'sensor_asap' => 0]);

        $resetStatusSensor = DataSensor::where('kode_sensor', $apiKey)->update(['status' => 0]);
        // $resetStatusDamkar = DataDamkar::where('nama', $damkar)->update(['status' => 0, 'helper' => 0]);
        $resetStatusDamkar = DataDamkar::where('nama', $damkar)->orWhere('helper', 1)->update(['status' => 0, 'helper' => 0]);
        if ($resetStatusSensor && $resetStatusDamkar) {
            return response()->json(['message' => 'success'], 200);
        } else {
            return response()->json(['message' => 'Failed'], 400);
        }
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