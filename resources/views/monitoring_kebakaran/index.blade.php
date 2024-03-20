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
    <div class="col-12 my-3">
        <h3 class="text-left">Sistem Monitoring Kebakaran daerah <b>Makassar</b></h3>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="table-responsive">
                    <table class="table" id=notif_status_sensor>
                        <caption class="ms-4">Real-time sensor, Data is updated every 5 seconds</caption>
                        <thead>
                            <tr>
                                <th>Sensor</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Bantuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="table-responsive">
                    <table class="table" id=damkar_status>
                        <caption class="ms-4">Data Damkar</caption>
                        <thead>
                            <tr>
                                <th>Damkar</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 mb-lg-0 my-4">
        <h5>Maps Sensor</h5>
        <div class="card">
            <div class="leaflet-map  m-1" id="sensorMaps"></div>
        </div>
    </div>

    <div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Permintaan Bantuan Pemadaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-10 mb-0">
                            <label for="emailLarge" class="form-label">Posko Damkar Yang Tersedia</label>
                            <select class="form-select" id="posko_damkar" name="posko_damkar" required>
                                <option value="" selected disabled>- Pilih Posko -</option>

                            </select>
                        </div>
                        <div class="col mb-0">
                            <button type="button" class="btn btn-primary my-4 " id="send">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var mapSensor = L.map('sensorMaps').setView([-5.1103816, 119.5018569], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapSensor);

                function fetchAndDisplayMarkersSensor() {
                    fetch('/monitoring_kebakaran/sensor_locations', {
                            headers: {
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                clearMarkers(mapSensor);
                                displayMarkersSensors(data, 'sensor', mapSensor);
                                populateTable(data);
                            } else {
                                console.log('No data available');
                                clearMarkers(mapSensor);
                                populateTable(data);
                            }

                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function displayMarkersSensors(locations, iconColor, map) {
                    locations.forEach(location => {
                        var latitude = location.latitude;
                        var longitude = location.longitude;
                        var nama = location.nama;

                        var customIcon = new L.Icon({
                            iconUrl: '{{ asset('assets') }}/img/icons/flame-icon.svg', // Ganti dengan path gambar ikon yang diinginkan
                            iconSize: [35, 35], // Sesuaikan ukuran ikon
                            iconAnchor: [17, 42] // Sesuaikan anchor ikon
                        });

                        var pulsingIcon = L.icon.pulse({
                            iconSize: [14, 14],
                            color: 'red'
                        });

                        L.marker([latitude, longitude], {
                                icon: pulsingIcon
                            })
                            .addTo(map);


                        L.marker([latitude, longitude], {
                                icon: customIcon
                            })
                            .addTo(map)
                            .bindPopup(nama, {
                                closeButton: true,
                                closeOnClick: true,
                                autoClose: true,
                            });
                    });
                }

                function clearMarkers(mapSensor) {
                    mapSensor.eachLayer(function(layer) {
                        if (layer instanceof L.Marker) {
                            mapSensor.removeLayer(layer);
                        }
                    });
                }

                function populateTable(data) {
                    var tableBody = document.getElementById('notif_status_sensor').getElementsByTagName('tbody')[0];

                    tableBody.innerHTML = "";

                    data.forEach(function(sensor) {
                        var row = tableBody.insertRow();
                        row.insertCell(0).innerHTML = sensor.kode_sensor;

                        var googleMapsLink = 'https://maps.google.com/maps?q=' + sensor.latitude + ',' + sensor
                            .longitude + '&hl=es;z=14&amp;output=embed>';

                        row.insertCell(1).innerHTML = '<a href="' + googleMapsLink +
                            '" target="_blank">Google Maps</a>';

                        row.insertCell(2).innerHTML =
                            `<span class="badge bg-label-danger me-1 blinking">Terjadi Kebakaran</span>`;

                        row.insertCell(3).innerHTML =
                            `<button class="btn btn-warning" id="help">Minta Bantuan</button>`;
                    });


                    $('#help').on('click', async function(event) {
                        fetch('/monitoring_kebakaran/helper', {
                                method: 'GET',
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Gagal mengambil data siswa');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log(data)
                                $('#posko_damkar').empty();

                                data.data.forEach(item => {
                                    $('#posko_damkar').append(
                                        `<option value="${item.id}">${item.nama}</option>`
                                    );
                                });

                                $('#largeModal').modal('show');
                                $('#send').on('click', async function() {
                                    var selectedItemId = $('#posko_damkar').val();
                                    if (selectedItemId) {
                                        try {
                                            const response = await fetch(
                                                '/damkarSelected/' +
                                                selectedItemId, {
                                                    method: 'GET',
                                                });

                                            if (!response.ok) {
                                                throw new Error(
                                                    'Gagal mengambil data dengan ID yang dipilih'
                                                );
                                            }

                                            const data = await response.json();
                                            if (response.status) {
                                                $('#largeModal').modal('hide');
                                                Swal.fire(
                                                    'Berhasil!',
                                                    'Meminta bantuan berhasil.',
                                                    'success'
                                                );
                                            } else {
                                                Swal.fire(
                                                    'Gagal!',
                                                    'Terjadi kesalahan .',
                                                    'error'
                                                );
                                            }

                                        } catch (error) {
                                            console.error('Error:', error);

                                        }
                                    } else {
                                        alert("Silakan pilih posko terlebih dahulu.");
                                    }
                                });
                            })
                    })

                }

                fetchAndDisplayMarkersSensor();
                setInterval(fetchAndDisplayMarkersSensor, 5000);

                function getDataDamkars() {
                    fetch('/monitoring_kebakaran/data_damakrs')
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);

                            tampilData(data);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function tampilData(data) {
                    var tableBody = document.getElementById('damkar_status').getElementsByTagName('tbody')[0];

                    tableBody.innerHTML = "";

                    data.forEach(function(damkar) {
                        var row = tableBody.insertRow();

                        var statusText = (damkar.status == 0) ? 'Ready' : 'Tidak tersedia';
                        var badgeClass = (damkar.status == 0) ? 'bg-label-success' : 'bg-label-warning';

                        var keteranganText = (damkar.status == 0) ? '-' : 'Sedang Menangani Kebakaran';

                        row.insertCell(0).innerHTML = damkar.nama;
                        row.insertCell(1).innerHTML =
                            `<span class="badge ${badgeClass} me-1 blinking">${statusText}</span>`;
                        row.insertCell(2).innerHTML = `${keteranganText}`;
                    });
                }


                getDataDamkars();
                setInterval(getDataDamkars, 5000);

            });
        </script>
    @endpush
@endsection
