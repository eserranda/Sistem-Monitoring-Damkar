@extends('layouts.master')
@push('css')
    {{-- map css --}}
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.css" />
@endpush
@section('content')
    <!-- Bootstrap Validation -->
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <h5 class="card-header">Tambah Data Sensor</h5>
                <div class="card-body">
                    <form class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label class="form-label" for="bs-validation-name">Kode Sensor</label>
                            <input type="text" class="form-control is-invalid" id="kode_sensor" name="kode_sensor"
                                placeholder="Kode Sensor" required />
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback"> </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-lg-5 mb-0">
                                <label class="form-label" for="">Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="form-control"
                                    placeholder="Latitude" required />
                            </div>

                            <div class="mb-3 col-lg-5 mb-0">
                                <label class="form-label" for="">Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-control"
                                    placeholder="Longitude" required />
                            </div>

                            <div class="mb-3 col-lg-2 d-flex align-items-center mb-0">
                                <button class="btn btn-info mt-4">
                                    <i class="ti ti-map-2 text-black"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="form-repeater-1-3">Tempat Sensor</label>
                            <select class="form-select" id="tempat_sensor" name="tempat_sensor" required>
                                <option value="">- Pilih Tempat -</option>
                                <option value="Male">Rumah</option>
                                <option value="Female">Gedung</option>
                            </select>
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback"> </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="formValidationBio">Alamat</label>
                            <textarea class="form-control" id=" " name=" " rows="2" required></textarea>
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback"> </div>
                        </div>


                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="leaflet-map" id="userLocation"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- /Bootstrap Validation -->

    @push('script')
        {{-- maps --}}
        <script src="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.js"></script>
        <script src="{{ asset('assets') }}/js/maps-leaflet.js"></script>


        {{-- <script src="{{ asset('assets') }}/vendor/libs/select2/select2.js"></script> --}}
    @endpush
@endsection
