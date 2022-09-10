@extends('admin.layout')

@section('css')
    <link href="{{ asset('/adminlte/plugins/select2/select2.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
          integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/admin">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/admin/quarry">Quarry</a>
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

                        <div class="form-group w-100 mb-2">
                            <label for="city" class="f14">Kota / Kabupaten</label>
                            <select class="select2 f14" name="city" id="city" style="width: 100%;">
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}"
                                            class="f14">{{ ucwords(strtolower($city->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group w-100 mb-2">
                            <label for="company" class="f14">Perusahaan</label>
                            <select class="select2 f14" name="company" id="company" style="width: 100%;">
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}"
                                            class="f14">{{ ucwords(strtolower($company->name)) }}</option>
                                @endforeach
                            </select>
                        </div>
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
                            <label for="large" class="form-label f14">Luas</label>
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
                        <div class="row mb-2">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="w-100 mb-2">
                                    <label for="latitude" class="form-label f14">Latitude</label>
                                    <input type="number" step="any" class="form-control f14" id="latitude"
                                           placeholder="0" value="0"
                                           name="latitude">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="w-100 mb-2">
                                    <label for="longitude" class="form-label f14">Longitude</label>
                                    <input type="number" step="any" class="form-control f14" id="longitude"
                                           placeholder="0" value="0"
                                           name="longitude">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="document">Photo</label>
                            <div class="needsclick dropzone" id="document-dropzone">
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve'
            });
        })
    </script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function () {
            var uploadedDocumentMap = {}
            $("#document-dropzone").dropzone({
                {{--url: '{{ route('products.storeMedia') }}',--}}
                url: '/admin/quarry/tambah',
                maxFilesize: 2, // MB
                addRemoveLinks: true,
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                autoProcessQueue: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                init: function () {
                    var myDropzone = this;
                    // Update selector to match your button
                    $("#btn-save").click(function (e) {
                        e.preventDefault();
                        myDropzone.processQueue();
                    });

                    this.on('sending', function (file, xhr, formData) {
                        // Append all form inputs to the formData Dropzone will POST
                        // console.log(file);
                        var data = $('#form-input').serializeArray();
                        $.each(data, function (key, el) {
                            // formData.append(el.name, el.value);
                        });
                        formData.append('file', file);
                    });

                    this.on("addedfile", function (file) {
                        console.log(file);
                        let name = file.name;
                        let reader = new FileReader();
                        reader.readAsDataURL(file);
                        console.log(reader.result);
                        let new_file = new File([reader.result], name);
                        // console.log(new_file)
                        $('#form-input').append('<input type="file" hidden name="images[]" value="' + new_file + '"/>')
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
        })
    </script>
@endsection
