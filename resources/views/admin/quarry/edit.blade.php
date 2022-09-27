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
                <li class="breadcrumb-item active" aria-current="page">Edit
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
                            <form method="post" enctype="multipart/form-data" id="form-input">
                                @csrf
                                <div class="w-100 mb-2">
                                    <label for="name" class="form-label f14">Nama Quarry</label>
                                    <input type="text" class="form-control f14" id="name" placeholder="Nama Quarry"
                                           name="name" value="{{ $data->name }}">
                                </div>
                                <div class="form-group w-100 mb-2">
                                    <label for="city" class="f14">Kota / Kabupaten {{ $data->city_id }}</label>
                                    <select class="select2 f14" name="city" id="city" style="width: 100%;">
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}"
                                                    {{ $data->city_id == $city->id ? 'selected' : '' }}
                                                    class="f14">{{ ucwords(strtolower($city->name)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{--                                <div class="form-group w-100 mb-2">--}}
                                {{--                                    <label for="company" class="f14">Perusahaan</label>--}}
                                {{--                                    <select class="select2 f14" name="company" id="company" style="width: 100%;">--}}
                                {{--                                        @foreach($companies as $company)--}}
                                {{--                                            <option value="{{ $company->id }}"--}}
                                {{--                                                    {{ $data->company_id == $company->id ? 'selected' : '' }}--}}
                                {{--                                                    class="f14">{{ ucwords(strtolower($company->name)) }}</option>--}}
                                {{--                                        @endforeach--}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}
                                <div class="form-group w-100 mb-2">
                                    <label for="category" class="f14">Kategori</label>
                                    <select class="select2 f14" name="category" id="category" style="width: 100%;">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    {{ $data->category_id == $category->id ? 'selected' : '' }}
                                                    class="f14">{{ ucwords(strtolower($category->name)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-100 mb-2">
                                    <label for="large" class="form-label f14">Luas (meter persegi)</label>
                                    <input type="number" class="form-control f14" id="large" placeholder="0"
                                           name="large" value="{{ $data->large }}">
                                </div>
                                <div class="w-100 mb-2">
                                    <label for="permission" class="form-label f14">Ijin</label>
                                    <input type="text" class="form-control f14" id="permission" placeholder="Ijin"
                                           name="permission" value="{{ $data->permission }}">
                                </div>
                                <div class="w-100 mb-2">
                                    <label for="address" class="form-label f14">Alamat</label>
                                    <textarea rows="3" class="form-control f14" id="address" placeholder="Alamat"
                                              name="address">{{ $data->address }}</textarea>
                                </div>
                                {{--                                <div class="row mb-2">--}}
                                {{--                                    <div class="col-lg-6 col-md-6 col-sm-6">--}}
                                {{--                                        <div class="w-100 mb-2">--}}
                                {{--                                            <label for="latitude" class="form-label f14">Latitude</label>--}}
                                {{--                                            <input type="number" step="any" class="form-control f14" id="latitude"--}}
                                {{--                                                   placeholder="0" value="{{ $data->latitude }}"--}}
                                {{--                                                   name="latitude">--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="col-lg-6 col-md-6 col-sm-6">--}}
                                {{--                                        <div class="w-100 mb-2">--}}
                                {{--                                            <label for="longitude" class="form-label f14">Longitude</label>--}}
                                {{--                                            <input type="number" step="any" class="form-control f14" id="longitude"--}}
                                {{--                                                   placeholder="0" value="{{ $data->longitude }}"--}}
                                {{--                                                   name="longitude">--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}

                                <hr>
                                <div class="w-100 text-right">
                                    <button type="submit" class="main-button f14" id="btn-save">
                                        <i class="fa fa-check mr-2"></i>
                                        <span>Simpan</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div id="tab-results" class="tab-pane fade" role="tabpanel" aria-labelledby="results-tab">
                            <form method="post" action="/admin/quarry/{{ $data->id }}/results" enctype="multipart/form-data">
                                @csrf
                                <div class="w-100 mb-3">
                                    <label for="results" class="form-label f14">Hasil Mutu</label>
                                    <textarea rows="3" class="form-control f14" id="results" placeholder="Hasil Mutu"
                                              name="results">{{ $data->results }}</textarea>
                                </div>
                                <div class="w-100 mb-2">
                                    <label for="file" class="form-label f14 mb-0">File Hasil Mutu <span
                                            style="font-weight: normal">
                                        @if($data->file != null)
                                                <a href="{{ $data->file }}" target="_blank">download</a>
                                            @else
                                                <span>(Belum Ada File Hasil Mutu)</span>
                                            @endif
                                    </span>
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file" name="file">
                                        <label class="custom-file-label f14" for="file">Pilih File Hasil Mutu...</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="w-100 text-right">
                                    <button type="submit" class="main-button f14" id="btn-save">
                                        <i class="fa fa-check mr-2"></i>
                                        <span>Simpan</span>
                                    </button>
                                </div>
                            </form>
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
                                            <div class="w-100 text-center">
                                                <a href="#" class="btn-remove-image" data-id="{{ $image->id }}">Hapus
                                                    File</a>
                                            </div>
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
                            <hr>
                            <div class="mb-4">
                                <label for="document">Gambar</label>
                                <div class="needsclick dropzone" id="document-dropzone">
                                </div>
                            </div>
                            <hr>
                            <div class="w-100 text-right">
                                <a href="#" class="main-button f14" id="btn-upload">
                                    <i class="fa fa-upload mr-2"></i>
                                    <span>Upload Gambar</span>
                                </a>
                            </div>
                        </div>
                        <div id="tab-location" class="tab-pane fade" role="tabpanel" aria-labelledby="location-tab">
                            <div id="map" class="mb-2"></div>
                            <hr>
                            <div class="w-100 text-right">
                                <a href="#" class="main-button f14" id="btn-change-coordinate">
                                    <i class="fa fa-check mr-2"></i>
                                    <span>Simpan</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/adminlte/plugins/select2/select2.js') }}"></script>
    <script src="{{ asset('/adminlte/plugins/select2/select2.full.js') }}"></script>
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"
            integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('/js/map-control.js') }}"></script>
    <script type="text/javascript">
        var id = '{{ $data->id }}';
        Dropzone.autoDiscover = false;
        var _lat = parseFloat('{{ $data->latitude }}'), _lng = parseFloat('{{ $data->longitude }}');

        async function removeMedia(id) {
            try {
                blockLoading(true);
                await $.post('/admin/quarry/' + id + '/media/destroy');
                blockLoading(false);
                SuccessAlert('Berhasil', 'Berhasil Menghapus Gambar...');
                window.location.reload();
            } catch (e) {
                blockLoading(false);
                ErrorAlert('Gagal', 'Terjadi Kesalahan...');
            }
        }

        async function patchLocation() {
            try {
                blockLoading(true);
                await $.post('/admin/quarry/' + id + '/location', {
                    latitude: _lat,
                    longitude: _lng
                });
                blockLoading(false);
                SuccessAlert('Berhasil', 'Berhasil Mengganti Koordinat...');
                window.location.reload();
            } catch (e) {
                blockLoading(false);
                ErrorAlert('Gagal', 'Terjadi Kesalahan...');
            }
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });
            var uploadedDocumentMap = {};
            $("#document-dropzone").dropzone({
                url: '/admin/quarry/' + id + '/media',
                maxFilesize: 2, // MB
                addRemoveLinks: true,
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 10,
                paramName: "images",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                init: function () {
                    var myDropzone = this;
                    // Update selector to match your button
                    $("#btn-upload").on('click', function (e) {
                        e.preventDefault();
                        blockLoading(true);
                        myDropzone.processQueue();
                    });

                    this.on('successmultiple', function (file, response) {
                        blockLoading(false);
                        SuccessAlert('Berhasil', 'Berhasil Menambahkan Data...');
                        window.location.reload();

                    });

                    this.on('errormultiple', function (file, response) {
                        blockLoading(false);
                        ErrorAlert('Error', 'Terjadi Kesalahan Server....')
                    });
                }
            });

            $('.btn-remove-image').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                AlertConfirm('Apakah Anda Yakin?', 'Apa anda yakin ingin melanjutkan proses', function () {
                    removeMedia(id);
                });
            });

            $('#data-tab').on('shown.bs.tab', function (e) {
                let tabId = e.target.id;
                if (tabId === 'location-tab') {
                    initMap('map');
                    changeOnClick(_lat, _lng, function (lat, lng) {
                        _lat = lat;
                        _lng = lng;
                    })
                }
            });

            $('#btn-change-coordinate').on('click', function (e) {
                e.preventDefault();
                AlertConfirm('Apakah Anda Yakin?', 'Apa anda yakin ingin melanjutkan proses', function () {
                    patchLocation();
                });
            });
            $('.custom-file-input').on('change', function () {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        })
    </script>
@endsection
