<?php

namespace App\Http\Controllers;

use App\Models\DataDamkar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataDamkarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DataDamkar::all();
        return view('damkar.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('damkar.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $tipeMarker = "damkar";

        $validator = Validator::make($request->all(), [
            'id_damkar' => 'required|unique:data_damkars',
            'nama' => 'required|unique:data_damkars',
            'latitude' => 'required|unique:data_damkars',
            'longitude' => 'required|unique:data_damkars',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 422);
        }

        $request->merge(['tipe_marker' => 'damkar']);

        DataDamkar::create($request->all());
        return response()->json(['success' => true], 201);
    }

    public function damkarLocations(DataDamkar $dataSensor)
    {
        $dataSensor = DataDamkar::all();
        return response()->json(['status' => true, 'data' => $dataSensor], 200);
    }

    public function poskoDamkarLocation(DataDamkar $dataSensor)
    {
        $id_user = auth()->user()->id;
        $location = DataDamkar::where('id_damkar', $id_user)->get(['latitude', 'longitude', 'nama']);
        return response()->json(['status' => true, 'data' => $location], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(DataDamkar $dataDamkar, $id)
    {
        $dataDamkar = $dataDamkar->find($id);
        // dd($dataDamkar);
        return view('damkar.edit', compact('dataDamkar', 'dataDamkar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataDamkar $dataDamkar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataDamkar $dataDamkar)
    {
        $validator = Validator::make($request->all(), [
            'id_damkar' => 'required',
            'nama' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 422);
        }

        $dataDamkar->where('id', $request->id)->update([
            'id_damkar' => $request->id_damkar,
            'nama' => $request->nama,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'alamat' => $request->alamat,
        ]);

        return response()->json(['success' => true], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataDamkar $dataDamkar, $id)
    {
        try {
            $dataDamkar::findOrFail($id)->delete();;
            return response()->json(['status' => true, 'message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}
