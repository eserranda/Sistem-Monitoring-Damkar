@extends('layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

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
                            <input type="text" class="form-control" id="bs-validation-name" placeholder="Kode Sensor"
                                required />
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback"> </div>
                        </div>


                        <div class="row">
                            <div class="mb-3 col-lg-5 mb-0">
                                <label class="form-label" for="">Latitude</label>
                                <input type="text" id="" class="form-control" placeholder="Latitude" required />
                            </div>

                            <div class="mb-3 col-lg-5 mb-0">
                                <label class="form-label" for="">Longitude</label>
                                <input type="text" id="" class="form-control" placeholder="Longitude"
                                    required />
                            </div>

                            <div class="mb-3 col-lg-2 d-flex align-items-center mb-0">
                                <button class="btn btn-label-danger mt-4" data-repeater-delete>
                                    <i class="ti ti-x ti-xs me-1"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="form-repeater-1-3">Tempat Sensor</label>
                            <select id="form-repeater-1-3" class="form-select" required>
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


        <script src="{{ asset('assets') }}/vendor/libs/select2/select2.js"></script>
        <script src="{{ asset('assets') }}/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
        <script src="{{ asset('assets') }}/vendor/libs/moment/moment.js"></script>
        <script src="{{ asset('assets') }}/vendor/libs/flatpickr/flatpickr.js"></script>
        <script src="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.js"></script>
        <script src="{{ asset('assets') }}/vendor/libs/tagify/tagify.js"></script>
        <script src="{{ asset('assets') }}/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
        <script src="{{ asset('assets') }}/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
        <script src="{{ asset('assets') }}/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
        <script src="{{ asset('assets') }}/js/form-validation.js"></script>
    @endpush
@endsection
