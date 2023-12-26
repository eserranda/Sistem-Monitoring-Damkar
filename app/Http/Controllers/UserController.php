<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function index()
    {
        $data = User::all();
        return view('akun.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    function addUser()
    {
        return view('akun.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'role' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], 422);
        }

        $user = User::create([
            'name' => request('name'),
            'username' => request('username'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'role' => request('role'),
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran Berhasil',
                'data' => $user,
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran Gagal',
            ], 500);
        }
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