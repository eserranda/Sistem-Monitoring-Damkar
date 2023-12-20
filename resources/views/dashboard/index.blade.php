@extends('layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.css" />
    <script src="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.js"></script>
@endpush
@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="row">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title m-0 me-2">Data Sensor</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="teamMemberList" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="teamMemberList">
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless border-top">
                        <thead class="border-bottom">
                            <tr>
                                <th>Sensor</th>
                                <th>Koneksi</th>
                                <th>STATUS</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataSensor as $key)
                                <tr>
                                    <td>{{ $key->nama }}</td>
                                    <td><span class="badge bg-danger">Ofline</span></td>
                                    <td><span class="badge bg-success">Aman</span></td>
                                    <td>-</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title m-0 me-2">Data Damkar</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="teamMemberList" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="teamMemberList">
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless border-top">
                        <thead class="border-bottom">
                            <tr>
                                <th>Posko</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataDamkar as $key)
                                <tr>
                                    <td>{{ $key->nama }}</td>
                                    <td><span class="badge bg-success">Stanby</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-lg-5">
        <div class="col-lg-6 mb-lg-0 mb-4">
            <h5>Maps Sensor</h5>
            <div class="card">
                <div class="leaflet-map  m-1" id="sensorMaps"></div>
            </div>
        </div>

        <div class="col-lg-6 mb-lg-0">
            <h5>Maps Damkar</h5>
            <div class="card">
                <div class="leaflet-map  m-1" id="damkarMaps"></div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var mapSensor = L.map('sensorMaps').setView([-5.1103816, 119.5018569], 13);
                var mapDamkar = L.map('damkarMaps').setView([-5.1103816, 119.5018569], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapSensor);

                function fetchAndDisplayMarkersSensor() {
                    fetch('/sensor_locations')
                        .then(response => response.json())
                        .then(data => {
                            // clearMarkers();
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                fetchAndDisplayMarkersSensor();


                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapDamkar);

                function fetchAndDisplayMarkersDamkar() {
                    fetch('/sensor_locations')
                        .then(response => response.json())
                        .then(data => {
                            // clearMarkers();
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                fetchAndDisplayMarkersDamkar();
                // setInterval(fetchAndDisplayMarkers, 5000);
            });
        </script>
    @endpush
@endsection
