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

        /* tidak di gunakan */
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

    <div class="col-12 my-3">
        <h3 class="text-center  ">Sistem Monitoring Kebakaran <b>{{ Auth::user()->name }}</b></h3>
        <div class="card">
            <div class="leaflet-map" style="width: 100%; height: 500px;" id="sensorMaps"></div>
        </div>
    </div>

    @push('script')
        <script>
            var flashingInterval;

            function startFlashing() {
                flashingInterval = setInterval(function() {
                    var sensorMaps = document.getElementById('sensorMaps');
                    sensorMaps.classList.toggle('flash-border');
                }, 1000);
            }

            function stopFlashing() {
                clearInterval(flashingInterval);
                var sensorMaps = document.getElementById('sensorMaps');
                sensorMaps.classList.remove('flash-border');
            }

            var mapSensor = L.map('sensorMaps').setView([-5.1103816, 119.5018569], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(mapSensor);

            function clearMarkers(mapSensor) {
                mapSensor.eachLayer(function(layer) {
                    if (layer instanceof L.Marker) {
                        mapSensor.removeLayer(layer);
                    }
                });
            }

            function fetchAndDisplayMarkersSensor() {
                fetch('/sensor_locations', {
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        // clearMarkers(mapSensor);
                        tampilkanMarker(data.data, 'sensor', mapSensor);
                        // console.log(data.data);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            fetchAndDisplayMarkersSensor()

            function fetchAndDisplayMarkersDamkar() {
                fetch('/posko/damkar_location')
                    .then(response => response.json())
                    .then(data => {
                        // clearMarkers(mapDamkar);

                        // console.log(data.data);
                        tampilkanMarker(data.data, 'damkar', mapSensor);
                        // console.log(data.data);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            fetchAndDisplayMarkersDamkar();

            function tampilkanMarker(locations, iconColor, map) {
                locations.forEach(location => {
                    var latitude = location.latitude;
                    var longitude = location.longitude;
                    var nama = location.nama;
                    // Mengecek apakah nilai dari location.nama mengandung kata "Sensor"
                    if (/Damkar/i.test(nama)) {
                        var customIcon = new L.Icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        })
                    } else {
                        var customIcon = new L.Icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        })
                    }

                    L.marker([latitude, longitude], {
                            icon: customIcon
                        })
                        .addTo(map)
                        .bindPopup(nama, {
                            closeButton: false,
                            closeOnClick: false,
                            autoClose: false,
                        })
                        .openPopup();
                });
            }

            function fetchStatusSensors() {
                fetch('/data_monitoring')
                    .then(response => response.json())
                    .then(data => {
                        // console.log(data);
                        const damkarLatitude = data.damkar_location[0].latitude;
                        const damkarLongitude = data.damkar_location[0].longitude;
                        const namaDamkar = data.damkar_location[0].nama;

                        const latitude = data.data_sensor[0].latitude;
                        const longitude = data.data_sensor[0].longitude;
                        const nama = data.data_sensor[0].nama;

                        const keterangan = data.status_sensor[0]

                        const key = Object.keys(keterangan)[0];
                        // const value = keterangan[key];
                        if (key === "sensor_api") {
                            keterangan[key] = "Api Terdeteksi";
                        } else if (key === "sensor_gas") {
                            keterangan[key] = "Gas Terdeteksi";
                        } else if (key === "sensor_asap") {
                            keterangan[key] = "Asap Terdeteksi";
                        }

                        keteranganSensor = keterangan[key];

                        var statusSensor = data.data_sensor.find(item => item.status === "1");

                        if (statusSensor) {
                            console.log("Sensor with status 1 found!");
                            startFlashing()
                            clearMarkers(mapSensor);
                            clearInterval(intervalId); // hetikan fetch data

                            displayWarningMarkersSensors(latitude, longitude, keteranganSensor, nama, 'red', mapSensor,
                                damkarLatitude,
                                damkarLongitude);

                        } else {
                            console.log("No sensor with status 1 found.");
                        }
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            intervalId = setInterval(fetchStatusSensors, 5000);

            function displayWarningMarkersSensors(latitude, longitude, keteranganSensor, nama, iconColor, mapSensor,
                damkarLatitude, damkarLongitude) {

                var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapSensor);

                const namaDamkar = "Posko Damkar"

                L.marker([damkarLatitude, damkarLongitude])
                    .addTo(mapSensor)
                // .bindPopup(namaDamkar, {
                //     closeButton: false,
                //     closeOnClick: false,
                //     autoClose: false,
                // })
                // .openPopup();

                var pulsingIcon = L.icon.pulse({
                    iconSize: [14, 14],
                    color: 'red'
                });

                var waypoints = [
                    L.latLng(damkarLatitude, damkarLongitude), // Koordinat Titik A
                    L.latLng(latitude, longitude) // Koordinat Titik  B
                ];

                var control = L.Routing.control({
                    waypoints: waypoints,
                    createMarker: function(i, waypoint, n) {
                        if (i === n - 1) {
                            return L.marker(waypoint.latLng, {
                                icon: pulsingIcon
                            });
                        }
                    },
                    routeWhileDragging: true,
                    show: false,
                    showAlternatives: true, // Menunjukkan jalur alternatif

                    altLineOptions: {
                        styles: [{
                            color: 'green',
                            opacity: 0.6,
                            weight: 4
                        }]
                    }
                }).addTo(mapSensor)

                // Menanggapi perubahan pada waypoints dan menyesuaikan tampilan peta
                control.on('waypointschanged', function(event) {
                    var newWaypoints = event.waypoints.map(function(wp) {
                        return wp.latLng;
                    });
                    // Menyesuaikan tampilan peta agar mencakup semua marker dan waypoints yang baru
                    mapSensor.fitBounds(L.latLngBounds(newWaypoints));
                });

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
                                        <p class="card-text mb-1"><strong> ${keteranganSensor} </strong></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="card-text mb-1"><strong>Jarak </strong> </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="card-text mb-1"> <span id="distanceValue"> </span></p>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <button class="btn btn-danger">Tangani</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-success">Selesai</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                $('#sensorMaps').prepend(sensorInfoContent);

                $('.btn-danger').on('click', function() {
                    alert('Tombol Tangani diklik!');
                });

                $('.btn-success').on('click', function() {
                    alert('Tombol Selesai diklik!');
                });


                control.on('routesfound', function(event) {
                    var route = event.routes[0];
                    var distanceInMeters = route.summary.totalDistance;

                    // Konversi nilai jarak ke kilometer
                    var distanceInKilometers = distanceInMeters / 1000;

                    // Menampilkan nilai jarak pada elemen dengan id 'distanceValue'
                    $('#distanceValue').text(distanceInKilometers.toFixed(2) + ' Km'); // Menampilkan 2 angka desimal
                });

            }
        </script>
    @endpush
@endsection

{{-- // for (const location of data.location) {
// const damkarLatitude = location.latitude;
// const damkarLongitude = location.longitude;
// console.log(damkarLatitude, damkarLongitude);
// } --}}
