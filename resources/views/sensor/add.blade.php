@extends('layouts.master')
@push('css')
    {{-- map css --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />

    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.css" />
    <script src="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.js"></script> --}}
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.css" />
    <script src="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.js"></script>
@endpush
@section('content')
    <!-- Bootstrap Validation -->
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <h5 class="card-header">Tambah Data Sensor</h5>
                <div class="card-body">
                    <form action="" method="POST" id="form_data_sensor" novalidate>
                        <div class="mb-3">
                            <label class="form-label" for="bs-validation-name">Kode Sensor</label>
                            <input type="text" class="form-control" id="kode_sensor" name="kode_sensor"
                                placeholder="Kode Sensor" required oninput="enableRadio()" />
                            <div class="invalid-feedback"> </div>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label" for="form-repeater-1-3">Kode Sensor</label>
                            <select class="form-select" id="kode_sensor" name="kode_sensor" onchange="enableRadio()"
                                required>
                                <option value="">- Kode Sensor -</option>
                                <option value="Sensor01">Sensor01</option>
                                <option value="Sensor02">Sensor02</option>
                            </select>
                            <div class="invalid-feedback"> </div>
                        </div> --}}

                        <div class="mb-3">
                            <div class="row row-bordered g-0">

                                {{-- <div class="form-check">
                                    <input name="mode" class="form-check-input" type="radio" value="myLocation"
                                        id="defaultRadio3" disabled />
                                    <label class="form-check-label" for="defaultRadio2"> Lokasi Saat Ini </label>
                                </div> --}}

                                <div class="form-check">
                                    <input name="mode" class="form-check-input" type="radio" value="gps"
                                        id="defaultRadio2" onchange="updateDatabaseAndSetMode('gps')" disabled />
                                    <label class="form-check-label" for="defaultRadio2"> GPS </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input name="mode" class="form-check-input" type="radio" value="manual"
                                        id="defaultRadio1" onchange="updateDatabaseAndSetMode('manual')" disabled />
                                    <label class="form-check-label" for="defaultRadio1"> Manual </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-lg-5 mb-0">
                                <label class="form-label" for="">Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="form-control"
                                    placeholder="Latitude" value="-5.11038164480454" required />
                            </div>

                            <div class="mb-3 col-lg-5 mb-0">
                                <label class="form-label" for="">Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-control"
                                    placeholder="Longitude" value=" 119.50185691687646" required />
                            </div>

                            <div class="mb-3 col-lg-2 style="display: none;" id="tombolViewMaps">

                                <button type="button" class="btn btn-info mt-4 btn-sm" style="display: none;"
                                    id="viewMaps">
                                    <i class="ti ti-map-2 text-black"></i>
                                </button>

                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-12" style="display: none;" id="tombol">
                                <button class="btn btn-primary" id="lockLocationButton">Lock
                                    Location</button>

                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="form-repeater-1-3">Tempat Sensor</label>
                            <select class="form-select" id="tempat_sensor" name="tempat_sensor" required>
                                <option value="">- Pilih Tempat -</option>
                                <option value="Rumah">Rumah</option>
                                <option value="Gedung">Gedung</option>
                            </select>
                            <div class="invalid-feedback"> </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="formValidationBio">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="/sensor"class="btn btn-warning">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card ">
                <div class="m-1 leaflet-map" style="height: 600px;" id="map"></div>
            </div>
        </div>
    </div>


    @push('script')
        <script>
            async function fetchData() {
                try {
                    const kodeSensor = document.getElementById('kode_sensor').value;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    const response = await fetch('/get-location', {
                        method: 'POST',
                        body: JSON.stringify({
                            apiKey: kodeSensor,
                        }),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    const data = await response.json();

                    // Pengecekan apakah data tidak kosong
                    if (Object.keys(data).length !== 0) {
                        document.getElementById('latitude').value = data.latitude;
                        document.getElementById('longitude').value = data.longitude;
                        show_maps();
                    } else {
                        console.error('Data kosong.');
                    }
                } catch (error) {
                    console.error('Error fetching data:', error);
                }
            }


            function startFetchingData() {
                fetchDataInterval = setInterval(fetchData, 5000); // Fetch data setiap 5 detik
            }

            function stopFetchingData() {
                clearInterval(fetchDataInterval); // Hentikan interval
            }

            document.getElementById("lockLocationButton").addEventListener("click", function(event) {
                event.preventDefault();
                stopFetchingData();
            });

            async function updateMode(data) {
                try {
                    const kodeSensor = document.getElementById('kode_sensor').value;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    await fetch('/update-mode', {
                        method: 'POST',
                        body: JSON.stringify({
                            apiKey: kodeSensor,
                            mode: data
                        }),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    if (data === "gps") {
                        startFetchingData();
                    }
                } catch (error) {
                    console.error('Error updating mode:', error);
                }
            }

            function updateDatabaseAndSetMode(mode) {
                if (mode === "manual") {
                    updateMode("manual");
                    stopFetchingData();
                    document.getElementById('latitude').value = "-5.11038164480454";
                    document.getElementById('longitude').value = " 119.50185691687646";
                    document.getElementById('tombol').style.display = 'none';
                    document.getElementById('tombolViewMaps').style.display = '';
                } else if (mode === "gps") {
                    document.getElementById('latitude').value = "";
                    document.getElementById('longitude').value = "";
                    document.getElementById('tombol').style.display = '';
                    document.getElementById('tombolViewMaps').style.display = 'none';
                    updateMode("gps");
                }
            }


            function enableRadio() {
                let kodeSensor = document.getElementById("kode_sensor").value;
                let radios = document.querySelectorAll('input[name="mode"]');

                if (kodeSensor.trim() !== "") {
                    radios.forEach(function(radio) {
                        radio.disabled = false;
                        radio.checked = false;
                    });
                } else {
                    radios.forEach(function(radio) {
                        radio.disabled = true;
                        radio.checked = false;
                    });
                }
            }

            function handleValidationErrors(errors) {
                if (errors && typeof errors === 'object') {
                    Object.keys(errors).forEach(fieldName => {
                        const inputField = document.getElementById(fieldName);
                        inputField.classList.add('is-invalid');
                        inputField.nextElementSibling.textContent = errors[fieldName][0];
                    });

                    // Hapus kelas 'is-invalid' dari elemen formulir yang telah diperbaiki
                    const validFields = document.querySelectorAll('.is-invalid');
                    validFields.forEach(validField => {
                        const fieldName = validField.id;
                        if (!errors[fieldName]) {
                            validField.classList.remove('is-invalid');
                            validField.nextElementSibling.textContent = '';
                        }
                    });
                }
            }

            document.getElementById('form_data_sensor').addEventListener('submit', async function(event) {
                event.preventDefault();
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    const response = await fetch('{{ route('sensor.store') }}', {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    }).then(response => response.json());

                    if (!response.success) {
                        handleValidationErrors(response.errors);
                    } else if (response.success) {
                        console.log(response);
                        const invalidInputs = document.querySelectorAll('.is-invalid');
                        invalidInputs.forEach(invalidInput => {
                            invalidInput.value = '';
                            invalidInput.classList.remove('is-invalid');
                            const errorNextSibling = invalidInput.nextElementSibling;
                            if (errorNextSibling && errorNextSibling.classList.contains(
                                    'invalid-feedback')) {
                                errorNextSibling.textContent = '';
                            }
                        });
                        window.location.href = '/sensor';
                    }
                } catch (error) {
                    console.error('Terjadi kesalahan:', error);
                    throw error;
                }
            });

            // maps
            var map;

            function show_maps() {
                const longitudeInput = document.getElementById("longitude");
                const latitudeInput = document.getElementById("latitude");
                const kode = document.getElementById("kode_sensor").value;

                if (map) {
                    map.remove();
                }

                const longitude = longitudeInput.value;
                const latitude = latitudeInput.value;

                map = L.map('map').setView([latitude, longitude], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

                // var customIcon = L.divIcon({
                //     className: 'custom-icon',
                //     html: '<i class="ti ti-map-2 ti-sm text-black">',
                //     iconSize: [32, 32],
                //     iconAnchor: [16, 32],
                //     popupAnchor: [0, -32]
                // });

                // var marker = L.marker([latitude, longitude], {
                //     icon: customIcon
                // }).addTo(map);

                marker = L.marker([latitude, longitude]).addTo(map);
                marker.bindPopup(kode).openPopup();

                // Tambahkan event listener untuk menanggapi klik pada peta
                map.on('click', function(e) {
                    var clickedLatitude = e.latlng.lat;
                    var clickedLongitude = e.latlng.lng;

                    // Update nilai longitude dan latitude pada elemen HTML
                    longitudeInput.value = clickedLongitude;
                    latitudeInput.value = clickedLatitude;

                    marker.setLatLng([clickedLatitude, clickedLongitude]);
                });
            }

            document.getElementById("viewMaps").addEventListener("click", function(event) {
                event.preventDefault();
                show_maps();
            });
        </script>
    @endpush
@endsection
