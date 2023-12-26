@extends('layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.css" />
    <script src="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.js"></script>

    <script src="https://rawgit.com/mapshakers/leaflet-icon-pulse/master/src/L.Icon.Pulse.js"></script>
    <link rel="stylesheet" href="https://rawgit.com/mapshakers/leaflet-icon-pulse/master/src/L.Icon.Pulse.css" />
@endpush
@section('content')
    <style>
        #mapWarningSensors.flash-border {
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
            /* Sesuaikan dengan tinggi yang diinginkan */
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fullscreenModal">
            Warning
        </button>

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

    @push('script')
        <script>
            // var flashingInterval;

            // function startFlashing() {
            //     flashingInterval = setInterval(function() {
            //         var mapWarningSensors = document.getElementById('mapWarningSensors');
            //         mapWarningSensors.classList.toggle('flash-border');
            //     }, 500);
            // }


            // function stopFlashing() {
            //     clearInterval(flashingInterval);
            //     var mapWarningSensors = document.getElementById('mapWarningSensors');
            //     mapWarningSensors.classList.remove('flash-border');
            // }

            // function clearMap() {
            //     if (map) {
            //         map.off(); // Matikan event listener terkait peta
            //         map.remove(); // Hapus peta dari DOM
            //     }
            // }

            // function initializeMap() {
            //     var map = L.map('mapWarningSensors').setView([-5.1103816, 119.5018569], 13);

            //     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            //         attribution: '© OpenStreetMap contributors'
            //     }).addTo(map);
            // }

            // $('#fullscreenModal').on('shown.bs.modal', function() {
            //     initializeMap();
            //     startFlashing();
            // });

            // $('#fullscreenModal').on('hidden.bs.modal', function() {
            //     clearMap();
            //     stopFlashing();
            // });


            // modal.on('shown.bs.modal', function() {
            //     mapSensor.invalidateSize();
            //     startFlashing();
            // });
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

                var markerSensor;
                var mapSensor = L.map('mapWarningSensors').setView([-5.1103816, 119.5018569], 13);

                let intervalId;


                modal.on('hidden.bs.modal', function() {
                    stopFlashing();
                    intervalId = setInterval(fetchStatusSensors, 3000);
                });

                modal.on('shown.bs.modal', function() {
                    mapSensor.invalidateSize();
                    startFlashing();
                });

                function fetchStatusSensors() {
                    fetch('/status_sensors')
                        .then(response => response.json())
                        .then(data => {
                            var sensorWithStatusOne = data.data.find(item => item.status === '1');

                            if (sensorWithStatusOne) {
                                modal.modal('show');
                                startFlashing();

                                clearMarkers(mapSensor);

                                var latitude = sensorWithStatusOne.latitude;
                                var longitude = sensorWithStatusOne.longitude;
                                var nama = sensorWithStatusOne.nama;

                                displayMarkersSensors(latitude, longitude, nama, 'red', mapSensor);

                                clearInterval(intervalId);
                            }
                            console.log(data.data);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                intervalId = setInterval(fetchStatusSensors, 3000);

                function displayMarkersSensors(latitude, longitude, nama, iconColor, mapSensor) {
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

                    var pulsingIcon = L.icon.pulse({
                        iconSize: [14, 14],
                        color: 'red'
                    });

                    // tileLayer.on('load', function() {
                    var marker = L.marker([latitude, longitude], {
                            icon: pulsingIcon
                        })
                        .addTo(mapSensor)
                    // .bindPopup(nama)
                    // .openPopup();

                    mapSensor.invalidateSize();
                    mapSensor.setView([latitude, longitude], 13);
                    // }
                }

                function clearMarkers() {
                    mapSensor.eachLayer(function(layer) {
                        if (layer instanceof L.Marker) {
                            mapSensor.removeLayer(layer);
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
