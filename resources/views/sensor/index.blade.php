@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h>Hello</h>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <caption class="ms-4">Sensor Terdaftar</caption>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Sensor</th>
                            <th>Longitude</th>
                            <th>Langitude</th>
                            <th>Tempat Sensor</th>
                            <th>Alamat</th>
                            <th>Maps</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td> Sensor001</td>
                            <td>-6.17511</td>
                            <td>106.827</td>
                            <td>Rumah</td>
                            <td>Jl. Jend. Sudirman</td>
                            <td>Vies</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
