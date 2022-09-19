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
        #map {
            height: 600px;
            width: 100%
        }

        .select2-selection--multiple {
            /*min-height: 35px !important;*/
            line-height: 30px !important;
            min-height: 45px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: var(--primaryColor);
            border: 1px solid var(--primaryShade);
            border-radius: 4px;
            cursor: default;
            float: left;
            margin-right: 5px;
            margin-top: 5px;
            padding: 0 5px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            cursor: pointer;
            display: inline-block;
            font-weight: bold;
            margin-right: 2px;
        }

        #drop-filter {
            min-width: 25rem;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item active" aria-current="page">Dashboard
            </li>
        </ol>
    </div>
    <div class="card card-outline card-warning">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0">Pemetaan Quarry</p>
                <div class="dropdown">
                    <a href="#" class="main-button" data-toggle="dropdown">
                        <i class="fa fa-filter mr-1"></i>
                        <span>Filter</span>
                    </a>
                    <div class="dropdown-menu p-3 dropdown-menu-right" style="z-index: 1001;" id="drop-filter">
                        <div class="form-group">
                            <label for="categories" class="f14">Jenis Quarry</label>
                            <select class="select2 f14" name="categories[]" id="categories" style="width: 100%;"
                                    multiple="multiple">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            class="f14">{{ ucwords(strtolower($category->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group w-100">
                            <label for="cities" class="f14">Kota / Kabupaten</label>
                            <select class="select2 f14" name="cities[]" id="cities" style="width: 100%;"
                                    multiple="multiple">
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}"
                                            class="f14">{{ ucwords(strtolower($city->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="map"></div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('/adminlte/plugins/select2/select2.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.full.js') }}"></script>
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script src="{{ asset('/js/map-control.js') }}"></script>
    <script type="text/javascript">
        let cities = [];
        let categories = [];
        var isAdmin = '{{ in_array('admin', auth()->user()->roles) ? true : false }}';
        $(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation();
        });
        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });
            initMap('map');
            getGeoJSONQuarry();
            $('#cities').on('change', function () {
                cities = $('#cities').val();
                console.log(cities);
                getGeoJSONQuarry(cities, categories, false);
            });
            $('#categories').on('change', function () {
                categories = $('#categories').val();
                console.log(categories);
                getGeoJSONQuarry(cities, categories, false);
            });
        })
    </script>
@endsection
