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
            height: 350px;
            width: 100%
        }
        #document-dropzone {
            height: 300px;
        }

        .dropzone .dz-message {
            text-align: center;
            height: 260px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            overflow: scroll;
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
                    <a href="{{ env('PREFIX_URL') }}/admin">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ env('PREFIX_URL') }}/admin/quarry">Quarry</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah
                </li>
            </ol>
        </div>
        <section>
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <p class="mb-0">Form Data Quarry</p>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" id="form-input">
                        @csrf
                        <div class="w-100 mb-2">
                            <label for="name" class="form-label f14">Nama Quarry</label>
                            <input type="text" class="form-control f14" id="name" placeholder="Nama Quarry"
                                   name="name">
                        </div>
                        <div class="form-group w-100 mb-2">
                            <label for="city" class="f14">Kota / Kabupaten</label>
                            <select class="select2 f14" name="city" id="city" style="width: 100%;">
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}"
                                            class="f14">{{ ucwords(strtolower($city->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--                        <div class="form-group w-100 mb-2">--}}
                        {{--                            <label for="company" class="f14">Perusahaan</label>--}}
                        {{--                            <select class="select2 f14" name="company" id="company" style="width: 100%;">--}}
                        {{--                                @foreach($companies as $company)--}}
                        {{--                                    <option value="{{ $company->id }}"--}}
                        {{--                                            class="f14">{{ ucwords(strtolower($company->name)) }}</option>--}}
                        {{--                                @endforeach--}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}
                        <div class="form-group w-100 mb-2">
                            <label for="category" class="f14">Kategori</label>
                            <select class="select2 f14" name="category" id="category" style="width: 100%;">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            class="f14">{{ ucwords(strtolower($category->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-100 mb-2">
                            <label for="large" class="form-label f14">Luas (M<sup>2</sup>)</label>
                            <input type="number" class="form-control f14" id="large" placeholder="0" value="0"
                                   name="large">
                        </div>
                        <div class="w-100 mb-2">
                            <label for="permission" class="form-label f14">Ijin</label>
                            <input type="text" class="form-control f14" id="permission" placeholder="Ijin"
                                   name="permission">
                        </div>
                        <div class="w-100 mb-2">
                            <label for="address" class="form-label f14">Alamat</label>
                            <textarea rows="3" class="form-control f14" id="address" placeholder="Alamat"
                                      name="address"></textarea>
                        </div>
                        {{--                        <div class="row mb-2">--}}
                        {{--                            <div class="col-lg-6 col-md-6 col-sm-6">--}}
                        {{--                                <div class="w-100 mb-2">--}}
                        {{--                                    <label for="latitude" class="form-label f14">Latitude</label>--}}
                        {{--                                    <input type="number" step="any" class="form-control f14" id="latitude"--}}
                        {{--                                           placeholder="0" value="0"--}}
                        {{--                                           name="latitude">--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-lg-6 col-md-6 col-sm-6">--}}
                        {{--                                <div class="w-100 mb-2">--}}
                        {{--                                    <label for="longitude" class="form-label f14">Longitude</label>--}}
                        {{--                                    <input type="number" step="any" class="form-control f14" id="longitude"--}}
                        {{--                                           placeholder="0" value="0"--}}
                        {{--                                           name="longitude">--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="w-100 mb-2">
                            <label for="results" class="form-label f14">Hasil Mutu</label>
                            <textarea rows="3" class="form-control f14" id="results" placeholder="Hasil Mutu"
                                      name="results"></textarea>
                        </div>
                        <div class="w-100 mb-2">
                            <label for="file" class="form-label f14">File Hasil Mutu</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file" name="file">
                                <label class="custom-file-label f14" for="file">Pilih File Hasil Mutu...</label>
                            </div>
                        </div>
                        <div class="w-100 mb-2">
                            <label for="map">Koordinat</label>
                            <div id="map"></div>
                        </div>
                        <div class="w-100 mb-4">
                            <label for="document">Photo</label>
                            <div class="needsclick dropzone" id="document-dropzone">
                            </div>
                        </div>
                        <hr>
                        <div class="w-100 text-right">
                            <a href="#" class="main-button f14" id="btn-save">
                                <i class="fa fa-check mr-2"></i>
                                <span>Simpan</span>
                            </a>
                        </div>
                    </form>
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
        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });
        })
    </script>
    <script type="text/javascript">
        var prefix_url = '{{ env('PREFIX_URL') }}';
        Dropzone.autoDiscover = false;
        var _lat = null, _lng = null;
        $(document).ready(function () {
            var uploadedDocumentMap = {}
            $("#document-dropzone").dropzone({
                url: prefix_url+'/admin/quarry/tambah',
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
                    $("#btn-save").on('click', function (e) {
                        e.preventDefault();
                        blockLoading(true);
                        if (myDropzone.files.length > 0) {
                            myDropzone.processQueue();
                        } else {
                            let frm = $('#form-input')[0];
                            let f_data = new FormData(frm);
                            if (_lat !== null) {
                                f_data.append('latitude', _lat);
                            }
                            if (_lng !== null) {
                                f_data.append('longitude', _lng);
                            }
                            $.ajax({
                                type: "POST",
                                enctype: 'multipart/form-data',
                                url: prefix_url+"/admin/quarry/tambah",
                                data: f_data,
                                processData: false,
                                contentType: false,
                                cache: false,
                                timeout: 600000,
                                success: function (data) {
                                    blockLoading(false);
                                    SuccessAlert('Berhasil', 'Berhasil Menambahkan Data...');
                                    window.location.reload();
                                },
                                error: function (e) {
                                    blockLoading(false);
                                    ErrorAlert('Error', 'Terjadi Kesalahan Server....')
                                }
                            })
                        }
                    });
                    // var fd;
                    this.on('sending', function (file, xhr, formData) {
                        // Append all form inputs to the formData Dropzone will POST
                        var data = $('#form-input').serializeArray();
                        $.each(data, function (key, el) {
                            formData.append(el.name, el.value);
                        });
                        let frm = $('#form-input')[0];
                        let f_data = new FormData(frm);
                        formData.append('file', f_data.get('file'));
                        if (_lat !== null) {
                            formData.append('latitude', _lat);
                        }
                        if (_lng !== null) {
                            formData.append('longitude', _lng);
                        }
                    });

                    this.on('successmultiple', function (file, response) {
                        blockLoading(false);
                        SuccessAlert('Berhasil', 'Berhasil Menambahkan Data...');
                        window.location.reload();

                    });

                    this.on('errormultiple', function (file, response) {
                        blockLoading(false);
                        ErrorAlert('Error', 'Terjadi Kesalahan Server....');
                        $.each(file, function (k, v) {
                            myDropzone.removeFile(v);
                        });
                        console.log(file);
                    });
                }
                // success: function(file, response) {
                //     $('form').append('<input type="hidden" name="photo[]" value="' + response.name + '">')
                //     uploadedDocumentMap[file.name] = response.name
                // },
                // removedfile: function(file) {
                //     file.previewElement.remove()
                //     var name = ''
                //     if (typeof file.file_name !== 'undefined') {
                //         name = file.file_name
                //     } else {
                //         name = uploadedDocumentMap[file.name]
                //     }
                //     $('form').find('input[name="photo[]"][value="' + name + '"]').remove()
                // }
            });
            $('.custom-file-input').on('change', function () {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            })
            initMap('map');
            mapOnClick(function (lat, lng) {
                _lat = lat;
                _lng = lng;
            });
        })
    </script>
@endsection
