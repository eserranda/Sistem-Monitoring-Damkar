@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header header-elements">
            <span class="me-2">Data Sensor</span>

            <div class="card-header-elements ms-auto">
                <a href="/add_sensor" class="btn -bottom-3 btn-primary">
                    <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <caption class="ms-4">Sensor Terdaftar</caption>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Sensor</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
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
