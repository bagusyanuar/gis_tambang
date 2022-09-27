@extends('admin.layout')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
          integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
            integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
            crossorigin=""></script>
    <style>
        #single-map {
            height: 400px;
            width: 100%
        }
    </style>
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Gagal!", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="lazy-backdrop" id="overlay-loading"></div>
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/admin">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/admin/quarry">Quarry</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->name }}
                </li>
            </ol>
        </div>
        <section>
            <div class="card card-warning card-outline">
                <div class="card-header border-bottom-0">
                    <ul class="nav nav-tabs" role="tablist" id="data-tab">
                        <li class="nav-item">
                            <a href="#tab-info" class="nav-link active" id="info-tab" data-toggle="pill" role="tab"
                               aria-controls="tab-info" aria-selected="false">
                                Data Quarry
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-results" class="nav-link" id="results-tab" data-toggle="pill" role="tab"
                               aria-controls="tab-results" aria-selected="false">
                                Hasil Mutu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-gallery" class="nav-link" id="gallery-tab" data-toggle="pill" role="tab"
                               aria-controls="tab-gallery" aria-selected="false">
                                Galerry
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-location" class="nav-link" id="location-tab" data-toggle="pill" role="tab"
                               aria-controls="tab-location" aria-selected="false">
                                Lokasi
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div id="tab-info" class="tab-pane fade active show" role="tabpanel" aria-labelledby="info-tab">
                            <div class="w-100 mb-2">
                                <label for="name" class="form-label f14">Nama Quarry</label>
                                <input type="text" class="form-control f14" id="name" placeholder="Nama Quarry"
                                       name="name" value="{{ $data->name }}" readonly>
                            </div>
                            <div class="w-100 mb-2">
                                <label for="category" class="form-label f14">Jenis Quarry</label>
                                <input type="text" class="form-control f14" id="category" placeholder="Jenis Quarry"
                                       name="category" value="{{ $data->category->name }}" readonly>
                            </div>
                            <div class="w-100 mb-2">
                                <label for="province" class="form-label f14">Provinsi</label>
                                <input type="text" class="form-control f14" id="province" placeholder="Provinsi"
                                       name="province" value="{{ $data->city->province->name }}" readonly>
                            </div>
                            <div class="w-100 mb-2">
                                <label for="city" class="form-label f14">Kota / Kabupaten</label>
                                <input type="text" class="form-control f14" id="city" placeholder="Kota / Kabupaten"
                                       name="city" value="{{ $data->city->name }}" readonly>
                            </div>
                            {{--                            <div class="w-100 mb-2">--}}
                            {{--                                <label for="company" class="form-label f14">Nama Perusahaan</label>--}}
                            {{--                                <input type="text" class="form-control f14" id="company" placeholder="Nama Perusahaan"--}}
                            {{--                                       name="company" value="{{ $data->company->name }}" readonly>--}}
                            {{--                            </div>--}}
                            <div class="w-100 mb-2">
                                <label for="large" class="form-label f14">Luas (meter persegi)</label>
                                <input type="number" class="form-control f14" id="large" placeholder="0"
                                       name="large" value="{{ $data->large }}" readonly>
                            </div>
                            <div class="w-100 mb-2">
                                <label for="permission" class="form-label f14">Ijin</label>
                                <input type="text" class="form-control f14" id="permission" placeholder="Ijin"
                                       name="permission" value="{{ $data->permission }}" readonly>
                            </div>
                            <div class="w-100 mb-2">
                                <label for="address" class="form-label f14">Alamat</label>
                                <textarea rows="3" class="form-control f14" id="address" placeholder="Alamat"
                                          name="address" readonly>{{ $data->address }}</textarea>
                            </div>
                            {{--                            <div class="row mb-2">--}}
                            {{--                                <div class="col-lg-6 col-md-6 col-sm-6">--}}
                            {{--                                    <div class="w-100 mb-2">--}}
                            {{--                                        <label for="latitude" class="form-label f14">Latitude</label>--}}
                            {{--                                        <input type="number" step="any" class="form-control f14" id="latitude"--}}
                            {{--                                               placeholder="0"--}}
                            {{--                                               name="latitude" value="{{ $data->latitude }}" readonly>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-lg-6 col-md-6 col-sm-6">--}}
                            {{--                                    <div class="w-100 mb-2">--}}
                            {{--                                        <label for="longitude" class="form-label f14">Longitude</label>--}}
                            {{--                                        <input type="number" step="any" class="form-control f14" id="longitude"--}}
                            {{--                                               placeholder="0" value="{{ $data->longitude }}" readonly--}}
                            {{--                                               name="longitude">--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </div>
                        <div id="tab-results" class="tab-pane fade" role="tabpanel" aria-labelledby="results-tab">
                            <div class="w-100 mb-3">
                                <label for="results" class="form-label f14">Hasil Mutu</label>
                                <textarea rows="3" class="form-control f14" id="results" placeholder="Hasil Mutu"
                                          name="results" readonly>{{ $data->results }}</textarea>
                            </div>
                            <div class="w-100 mb-2">
                                <label for="file" class="form-label f14 mb-0">File Hasil Mutu</label>
                                @if($data->file != null)
                                <a href="{{ $data->file }}" target="_blank" class="d-block">download</a>
                                @else
                                    <p class="font-weight-bold">Belum Ada File Hasil Mutu</p>
                                @endif
                            </div>

                        </div>
                        <div id="tab-gallery" class="tab-pane fade" role="tabpanel" aria-labelledby="gallery-tab">
                            <div class="row">
                                @forelse($data->images as $image)
                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                        <div style="border: solid 1px gray; border-radius: 10px; padding: 5px 5px;"
                                             class="mb-2">
                                            <a href="{{ $image->image }}" target="_blank" class="mb-1">
                                                <img src="{{ $image->image }}" alt="quarry image" class="mb-2"
                                                     style="object-fit: cover; border-radius: 5px; height: 250px; width: 100%">
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="w-100 d-flex align-items-center justify-content-center"
                                             style="min-height: 200px;">
                                            <p class="font-weight-bold">Foto Quarry Tidak Tersedia</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div id="tab-location" class="tab-pane fade" role="tabpanel" aria-labelledby="location-tab">
                            <div id="single-map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script src="{{ asset('/js/map-control.js') }}"></script>
    <script type="text/javascript">
        let lat = '{{ $data->latitude }}';
        let lng = '{{ $data->longitude }}';
        let coordinates = [parseFloat(lat), parseFloat(lng)];
        $(document).ready(function () {

            $('#data-tab').on('shown.bs.tab', function (e) {
                let tabId = e.target.id;
                if (tabId === 'location-tab') {
                    removeSingleMapLayer();
                    initSingleMap('single-map');
                    createSingleMarker(coordinates);
                }
            });
        })
    </script>
@endsection
