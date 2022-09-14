@extends('admin.layout')

@section('css')
    <link href="{{ asset('/adminlte/plugins/select2/select2.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
          integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <p class="font-weight-bold">Filter</p>
        </div>
        <div class="form-group">
            <label for="cities" class="f14">Kota / Kabupaten</label>
            <select class="select2 f14" name="cities[]" id="cities" style="width: 100%;">
                <option class="">--pilih kota / kabupaten--</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}"
                            class="f14">{{ ucwords(strtolower($city->name)) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="map"></div>
@endsection
@section('js')
    <script src="{{ asset('/adminlte/plugins/select2/select2.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.full.js') }}"></script>
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script src="{{ asset('/js/map-control.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });
            initMap('map');
        })
    </script>
@endsection
