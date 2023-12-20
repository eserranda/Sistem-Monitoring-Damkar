<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

use function Laravel\Prompts\table;
use Kreait\Firebase\Contract\Database;

class RealTimeDataSensor extends Controller
{

    public function connect()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        return $firebase->createDatabase();
    }

    public function index()
    {
        $data = $this->connect()->getReference('Humadity')->getSnapshot()->getValue();
        return view('realtimedata.index', compact('data'));

        // Mengubah data menjadi format JSON
        // $jsonData = json_encode($data);

        // return response()->json(['data' => $data]);
        // return response()->json(['data' => $data])->header("Cache-Control", "no-store,no-cache, must-revalidate, post-check=0, pre-check=0");
    }
}
