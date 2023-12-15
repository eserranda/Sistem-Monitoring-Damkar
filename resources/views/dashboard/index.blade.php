@extends('layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.css" />
@endpush
@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="row">
        <!-- Basic -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="leaflet-map" id="basicMap"></div>
                </div>
            </div>
        </div>
        <!-- /Basic -->

        <div class="col-lg-4">
            <div class="card">
                <h5 class="card-header">Monitoring Sensor</h5>
                <div class="card-body">
                    <div class="text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Sensor</th>
                                    <th>Sensor Gas</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <tr>
                                    <td>1</td>
                                    <td>ID001</td>
                                    <td>1324</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

    @push('script')
        <script src="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.js"></script>
        <script src="{{ asset('assets') }}/js/maps-leaflet.js"></script>
    @endpush
@endsection
