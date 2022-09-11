@extends('admin.layout')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
          integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
            integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
            crossorigin=""></script>
    <style>
        #map { height: 600px; width: 100%}
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-briefcase"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Quarry</span>
                    <span class="info-box-number">{{ $quarries }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fa fa-address-book"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Perusahaan</span>
                    <span class="info-box-number">{{ $quarries }}</span>
                </div>
            </div>
        </div>
    </div>
    <div id="map"></div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            var map = L.map('map').setView([-7.179453738641357, 112.7740002901017], 10);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);
        })
    </script>
@endsection
