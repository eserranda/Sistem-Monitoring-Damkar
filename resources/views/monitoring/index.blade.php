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
            document.addEventListener('DOMContentLoaded', function() {
                var map = L.map('sensorMaps').setView([-5.1103816, 119.5018569], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                function fetchAndDisplayMarkers() {
                    fetch('/get-sensor-locations')
                        .then(response => response.json())
                        .then(data => {
                            clearMarkers();

                            displayMarkers(data.sensor_locations, map);
                            displayMarkers(data.damkar_locations, map);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function displayMarkers(locations, map) {
                    locations.forEach(location => {
                        var latitude = location.latitude;
                        var longitude = location.longitude;
                        var nama = location.nama;

                        L.marker([latitude, longitude]).addTo(map)
                            .bindPopup(nama, {
                                closeButton: false,
                                closeOnClick: false,
                                autoClose: false,
                            })
                            .openPopup();
                    })
                }

                function clearMarkers() {
                    map.eachLayer(function(layer) {
                        if (layer instanceof L.Marker) {
                            map.removeLayer(layer);
                        }
                    });
                }
                fetchAndDisplayMarkers();
                // setInterval(fetchAndDisplayMarkers, 5000);
            });
        </script>
    @endpush
@endsection
