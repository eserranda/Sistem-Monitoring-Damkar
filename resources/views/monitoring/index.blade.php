@extends('layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.css" />
    <script src="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.js"></script>
@endpush
@section('content')
    <div class="col-12">
        <h5>Lokasi Sensor</h5>
        <div class="card">
            <div class="leaflet-map  m-1" id="sensorMaps"></div>

        </div>
    </div>

    @push('script')
        <script>
            // Fetch data from the server
            document.addEventListener('DOMContentLoaded', function() {
                var map = L.map('sensorMaps').setView([-5.1103816, 119.5018569], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

                function fetchAndDisplayMarkers() {
                    fetch('/get-sensor-locations')
                        .then(response => response.json())
                        .then(data => {
                            displayMarkers(data.locations, map);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                fetchAndDisplayMarkers();
                setInterval(fetchAndDisplayMarkers, 5000);
            });

            function displayMarkers(locations, map) {
                locations.forEach(location => {
                    var marker = L.marker([location.latitude, location.longitude]).addTo(map);
                    marker.bindPopup(location.kode_sensor);
                });
            }
        </script>
    @endpush
@endsection
