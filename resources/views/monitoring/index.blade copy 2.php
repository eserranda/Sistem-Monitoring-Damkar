@extends('layouts.master')
@push('css')
<link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.css" />
<script src="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.js"></script>

<script src="https://rawgit.com/mapshakers/leaflet-icon-pulse/master/src/L.Icon.Pulse.js"></script>
<link rel="stylesheet" href="https://rawgit.com/mapshakers/leaflet-icon-pulse/master/src/L.Icon.Pulse.css" />

<!-- Tautan Skrip -->
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<!-- Gaya -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
@endpush
@section('content')
<style>
#sensorMaps.flash-border {
    box-shadow: 0 0 20px red;
    animation: flash 1s ease-in-out infinite;
    border-radius: 15px;
}

@keyframes flash {

    0%,
    100% {
        border-color: red;
    }

    50% {
        border-color: transparent;
    }
}

#sensorMaps {
    height: 400px;
}

#mapCard {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: white;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    z-index: 1000;
}
</style>

<div class="col-12">
    <h5>Maps Sensor dan Posko Damkar</h5>
    <div class="card">
        <!-- Card -->
        <div class="leaflet-map  m-1" id="sensorMaps"></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="modalFullTitle">PERINGATAN!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="leaflet-map" id="mapWarningSensors" style="height: 100%;">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

{{-- @push('script') --}}
{{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                var flashingInterval;

                function startFlashing() {
                    flashingInterval = setInterval(function() {
                        var mapWarningSensors = document.getElementById('mapWarningSensors');
                        mapWarningSensors.classList.toggle('flash-border');
                    }, 1000);
                }

                function stopFlashing() {
                    clearInterval(flashingInterval);
                    var mapWarningSensors = document.getElementById('mapWarningSensors');
                    mapWarningSensors.classList.remove('flash-border');
                }

                var modal = $('#fullscreenModal');
                var mapSensor = L.map('mapWarningSensors').setView([-5.1103816, 119.5018569], 13);

                var fetchingData = true;
                let intervalId;
                console.log(fetchingData);
                modal.on('hidden.bs.modal', function() {
                    stopFlashing();
                    intervalId = setInterval(fetchStatusSensors, 5000);
                    fetchingData = true;
                    if (mapSensor) {
                        mapSensor = null;
                    }
                });

                modal.on('shown.bs.modal', function() {
                    startFlashing();
                    mapSensor.invalidateSize();
                    fetchingData = false;
                });


                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapSensor);

                function fetchStatusSensors() {

                    if (!fetchingData) {
                        return;
                    }

                    fetch('/monitoring')
                        .then(response => response.json())
                        .then(data => {
                            // const damkarLatitude = data.location[0].latitude;
                            // const damkarLongitude = data.location[0].longitude;
                            // var sensorWithStatusOne = data.data.find(item => item.status === '1');

                            // if (sensorWithStatusOne) {
                            //     modal.modal('show');

                            //     var latitude = sensorWithStatusOne.latitude;
                            //     var longitude = sensorWithStatusOne.longitude;
                            //     var nama = sensorWithStatusOne.nama;

                            //     displayMarkersSensors(latitude, longitude, nama, 'red', mapSensor, damkarLatitude,
                            //         damkarLongitude);

                            //     clearInterval(intervalId);
                            // }
                            console.log(data.data);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                intervalId = setInterval(fetchStatusSensors, 5000);

                function displayMarkersSensors(latitude, longitude, nama, iconColor, mapSensor, damkarLatitude,
                    damkarLongitude) {

                    var sensorInfoContent = `
                        <div class="card m-0" style="position: absolute; top: 10px; right: 10px; z-index: 1000;">
                            <div class="card-body ">
                                <h4 class="card-title">Sensor Information  </h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="card-text mb-1"><strong>Sensor </strong> </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="card-text mb-1"><strong>${nama}</strong> </p>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="card-text mb-1"><strong>Keterangan </strong> </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="card-text mb-1">Api terdeteksi </p>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    `;

                    $('#mapWarningSensors').prepend(sensorInfoContent);

                    var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(mapSensor);

                    L.marker([damkarLatitude, damkarLongitude])
                        .addTo(mapSensor)

                    var pulsingIcon = L.icon.pulse({
                        iconSize: [14, 14],
                        color: 'red'
                    });

                    var control = L.Routing.control({
                        waypoints: [
                            L.latLng(damkarLatitude, damkarLongitude), // Koordinat Titik A
                            L.latLng(latitude, longitude) // Koordinat Titik B
                        ],
                        routeWhileDragging: true,
                        createMarker: function(i, waypoint, n) {
                            if (i === n - 1) {
                                return L.marker(waypoint.latLng, {
                                    icon: pulsingIcon
                                });
                            }
                        },
                        show: false
                    }).addTo(mapSensor);


                    var marker = L.marker([latitude, longitude], {
                            icon: pulsingIcon
                        })
                        .addTo(mapSensor)

                    mapSensor.invalidateSize();
                }


            });
        </script> --}}
{{-- @endpush --}}
@endsection

{{-- // for (const location of data.location) {
// const damkarLatitude = location.latitude;
// const damkarLongitude = location.longitude;
// console.log(damkarLatitude, damkarLongitude);
// } --}}