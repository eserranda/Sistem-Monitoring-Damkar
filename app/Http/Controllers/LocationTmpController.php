<?php

namespace App\Http\Controllers;

use App\Models\LocationTmp;
use Illuminate\Http\Request;

class LocationTmpController extends Controller
{

    public function updateMode(Request $request)
    {
        $apiKey = $request->input('apiKey');
        $mode = LocationTmp::where('apiKey', $apiKey)->update([
            'mode' => $request->input('mode')
        ]);
        return response()->json(["status" => "success", "message" => "Mode updated successfully", "data" => $mode]);
    }

    public function getLoc(Request $request)
    {
        $apiKey = "Sensor01";
        $data = LocationTmp::where('apiKey', $apiKey)->first();
        return response()->json($data);
    }

    public function mode(Request $request)
    {
        $apiKey = $request->input('apiKey');
        $mode = LocationTmp::where('apiKey', $apiKey)->first();
        return response()->json($mode->mode);
    }

    public function saveLoc(Request $request)
    {
        // Mengambil data dari request
        $apiKey = $request->input('apiKey');
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $location = LocationTmp::updateOrCreate(
            ['apiKey' => $apiKey],
            ['latitude' => $lat, 'longitude' => $lng]
        );

        // Mengembalikan respon JSON
        return response()->json([
            'message' => 'Data lokasi berhasil disimpan.',
            'data' => $location
        ]);
    }

    public function index()
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
    public function show(LocationTmp $locationTmp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LocationTmp $locationTmp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LocationTmp $locationTmp)
    {
        //
    }
}
