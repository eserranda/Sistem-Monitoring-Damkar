@extends('layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.css" />
@endpush
@section('content')
    <div class="col-12">
        <div class="card mb-4">
            <h5 class="card-header">User Location</h5>
            <div class="card-body">
                <div class="leaflet-map" id="userLocation"></div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('assets') }}/vendor/libs/leaflet/leaflet.js"></script>
        <script src="{{ asset('assets') }}/js/maps-leaflet.js"></script>
    @endpush
@endsection
