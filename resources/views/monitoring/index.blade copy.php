@extends('layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.css" />
    <script src="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.js"></script>
@endpush
@section('content')
    <style>
        #mapWarningSensors {
            /* border: 3px solid red; */
            border-radius: 10px;
        }

        #mapWarningSensors.flash-border {
            box-shadow: 0 0 25px red;
            animation: flash 1s ease-in-out;
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
    </style>
    <div class="col-12">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fullscreenModal">
            Warning
        </button>

        <h5>Maps Sensor dan Posko Damkar</h5>
        <div class="card">
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
                    <div class="leaflet-map" id="mapWarningSensors" style="height: 100%;"></div>
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
            var flashingInterval;

            function startFlashing() {
                flashingInterval = setInterval(function() {
                    var mapWarningSensors = document.getElementById('mapWarningSensors');
                    mapWarningSensors.classList.toggle('flash-border');
                }, 500);
            }


            function stopFlashing() {
                clearInterval(flashingInterval);
                var mapWarningSensors = document.getElementById('mapWarningSensors');
                mapWarningSensors.classList.remove('flash-border');
            }

            function clearMap() {
                if (map) {
                    map.off(); // Matikan event listener terkait peta
                    map.remove(); // Hapus peta dari DOM
                }
            }

            function initializeMap() {
                var map = L.map('mapWarningSensors').setView([-5.1103816, 119.5018569], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
            }

            $('#fullscreenModal').on('shown.bs.modal', function() {
                initializeMap();
                startFlashing();
            });

            $('#fullscreenModal').on('hidden.bs.modal', function() {
                clearMap();
                stopFlashing();
            });


            // modal.on('shown.bs.modal', function() {
            //     mapSensor.invalidateSize();
            //     startFlashing();
            // });
            // document.addEventListener('DOMContentLoaded', function() {
            //     var flashingInterval;

            //     function startFlashing() {
            //         flashingInterval = setInterval(function() {
            //             var mapWarningSensors = document.getElementById('mapWarningSensors');
            //             mapWarningSensors.classList.toggle('flash-border');
            //         }, 500);
            //     }


            //     function stopFlashing() {
            //         clearInterval(flashingInterval);
            //         var mapWarningSensors = document.getElementById('mapWarningSensors');
            //         mapWarningSensors.classList.remove('flash-border');
            //     }

            //     var modal = $('#fullscreenModal');

            //     var markerSensor;
            //     var mapSensor = L.map('mapWarningSensors').setView([-5.1103816, 119.5018569], 13);

            //     let intervalId;


            //     modal.on('hidden.bs.modal', function() {
            //         stopFlashing();
            //     });

            //     modal.on('shown.bs.modal', function() {
            //         mapSensor.invalidateSize();
            //         startFlashing();
            //     });

            //     function fetchStatusSensors() {
            //         fetch('/status_sensors')
            //             .then(response => response.json())
            //             .then(data => {
            //                 var sensorWithStatusOne = data.data.find(item => item.status === '1');

            //                 if (sensorWithStatusOne) {
            //                     modal.modal('show');

            //                     if (markerSensor) {
            //                         mapSensor.removeLayer(mapSensor);
            //                     }
            //                     var latitude = sensorWithStatusOne.latitude;
            //                     var longitude = sensorWithStatusOne.longitude;
            //                     var nama = sensorWithStatusOne.nama;

            //                     displayMarkersSensors(latitude, longitude, nama, 'red', mapSensor);

            //                     // Hentikan interval setelah modal muncul
            //                     clearInterval(intervalId);
            //                 }
            //                 console.log(data.data);
            //             })
            //             .catch(error => console.error('Error fetching data:', error));
            //     }

            //     intervalId = setInterval(fetchStatusSensors, 3000);

            //     function displayMarkersSensors(latitude, longitude, nama, iconColor, mapSensor) {

            //         var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            //             attribution: '© OpenStreetMap contributors'
            //         })

            //         tileLayer.on('load', function() {
            //             // Buat custom icon
            //             var customIcon = new L.Icon({
            //                 iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-${iconColor}.png`,
            //                 shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            //                 iconSize: [25, 41],
            //                 iconAnchor: [12, 41],
            //                 popupAnchor: [1, -34],
            //                 shadowSize: [41, 41]
            //             });

            //             // Tambahkan marker ke peta
            //             var marker = L.marker([latitude, longitude], {
            //                     icon: customIcon
            //                 })
            //                 .addTo(mapSensor)
            //                 .bindPopup(nama)
            //                 .openPopup();
            //         });

            //         // Tambahkan tile layer ke peta
            //         tileLayer.addTo(mapSensor);

            //         // mapSensor.invalidateSize();
            //     }




            //     // var map = L.map('sensorMaps').setView([-5.1103816, 119.5018569], 13);

            //     // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            //     //     attribution: '© OpenStreetMap contributors'
            //     // }).addTo(map);

            //     // function fetchAndDisplayMarkers() {
            //     //     fetch('/get-sensor-locations')
            //     //         .then(response => response.json())
            //     //         .then(data => {
            //     //             clearMarkers();

            //     //             displayMarkers(data.sensor_locations, map);
            //     //             displayMarkers(data.damkar_locations, map);
            //     //         })
            //     //         .catch(error => console.error('Error fetching data:', error));
            //     // }

            //     // function displayMarkers(locations, map) {
            //     //     locations.forEach(location => {
            //     //         var latitude = location.latitude;
            //     //         var longitude = location.longitude;

            //     //         var nama = location.nama;
            //     //         var typeMarker = location.tipe_marker

            //     //         var iconUrl = '';
            //     //         var popupContent = '';

            //     //         if (typeMarker === 'sensor') {
            //     //             iconUrl =
            //     //                 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png';
            //     //             popupContent = 'Sensor: ' + nama;
            //     //         } else if (typeMarker === 'damkar') {
            //     //             iconUrl =
            //     //                 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png'; // ganti dengan URL ikon damkar yang sesuai
            //     //             popupContent = 'Posko Damkar: ' + nama;
            //     //         }


            //     //         // var greenIcon = new L.Icon({
            //     //         //     iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            //     //         //     shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            //     //         //     iconSize: [25, 41],
            //     //         //     iconAnchor: [12, 41],
            //     //         //     popupAnchor: [1, -34],
            //     //         //     shadowSize: [41, 41]
            //     //         // }); 
            //     //         var customIcon = new L.Icon({
            //     //             iconUrl: iconUrl,
            //     //             shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            //     //             iconSize: [25, 41],
            //     //             iconAnchor: [12, 41],
            //     //             popupAnchor: [1, -34],
            //     //             shadowSize: [41, 41]
            //     //         });

            //     //         L.marker([latitude, longitude], {
            //     //                 icon: customIcon
            //     //             })
            //     //             .addTo(map)
            //     //             .bindPopup(nama, {
            //     //                 closeButton: false,
            //     //                 closeOnClick: false,
            //     //                 autoClose: false,
            //     //             })
            //     //             .openPopup();
            //     //     })
            //     // }

            //     // function clearMarkers() {
            //     //     map.eachLayer(function(layer) {
            //     //         if (layer instanceof L.Marker) {
            //     //             map.removeLayer(layer);
            //     //         }
            //     //     });
            //     // }
            //     // fetchAndDisplayMarkers();
            // });
        </script>
    @endpush
@endsection
