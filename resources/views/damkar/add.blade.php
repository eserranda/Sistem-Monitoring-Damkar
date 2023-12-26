@extends('layouts.master')
@push('css')
    {{-- map css --}}
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.css" />
    <script src="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.js"></script>
@endpush
@section('content')
    <!-- Bootstrap Validation -->
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <h5 class="card-header">Tambah Data Posko</h5>
                <div class="card-body">
                    <form action="" method="POST" id="form_data_damkar" novalidate>
                        <div class="mb-3">
                            <label class="form-label" for="form-repeater-1-3">Pilih Poskoh</label>
                            <select class="form-select" id="id_damkar" name="id_damkar" required>
                                <option value="" selected disabled> Pilih Tempat </option>
                            </select>
                            <div class="invalid-feedback"> </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="bs-validation-name">Nama Posko</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Nama Posko" required readonly />
                            <div class="invalid-feedback"> </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-lg-5 mb-0">
                                <label class="form-label" for="">Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="form-control"
                                    placeholder="Latitude" value="-5.11038164480454" required />
                                <div class="invalid-feedback"> </div>

                            </div>

                            <div class="mb-3 col-lg-5 mb-0">
                                <label class="form-label" for="">Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-control"
                                    placeholder="Longitude" value=" 119.50185691687646" required />
                                <div class="invalid-feedback"> </div>
                            </div>

                            <div class="mb-3 col-lg-2 d-flex align-items-center mb-0">
                                <button type="button" class="btn btn-info mt-4 btn-sm" id="viewMaps">
                                    <i class="ti ti-map-2 text-black"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="formValidationBio">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                            <div class="invalid-feedback"> </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="/damkar"class="btn btn-warning">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card ">
                <div class="m-1 leaflet-map" id="map"></div>
            </div>
        </div>
    </div>


    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropdown = document.getElementById('id_damkar');
                const namaInput = document.getElementById('nama');

                let fetchedData;
                dropdown.addEventListener('change', function() {
                    const selectedUserId = dropdown.value;
                    const selectedUserData = fetchedData.data.find(user => user.id === parseInt(
                        selectedUserId));
                    if (selectedUserData) {
                        namaInput.value = selectedUserData.name;
                    } else {
                        namaInput.value = '';
                    }
                });

                // Fetch data dari backend
                fetch('get_data_users')
                    .then(response => response.json())
                    .then(data => {
                        if (data.status && data.data.length > 0) {
                            // Mengisi dropdown dengan data
                            data.data.forEach(user => {
                                const option = document.createElement('option');
                                option.value = user.id;
                                option.textContent = user.name;
                                dropdown.appendChild(option);
                            });
                            fetchedData = data;
                        } else {
                            console.error('Data tidak valid atau kosong');
                        }
                    })
                    .catch(error => console.error('Error fetching data:', error));
            });

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

            document.getElementById('form_data_damkar').addEventListener('submit', async function(event) {
                event.preventDefault();
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    const response = await fetch('{{ route('damkar.store') }}', {
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
                        window.location.href = '/damkar';
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
                const posko = document.getElementById("nama").value;

                if (map) {
                    map.remove();
                }

                const longitude = longitudeInput.value;
                const latitude = latitudeInput.value;

                map = L.map('map').setView([latitude, longitude], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);


                marker = L.marker([latitude, longitude]).addTo(map);
                marker.bindPopup(posko).openPopup();

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
