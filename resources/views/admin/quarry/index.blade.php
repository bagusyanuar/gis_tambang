@extends('admin.layout')

@section('css')
    <style>
        .dt-control {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/admin">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Quarry
                </li>
            </ol>
        </div>
    </div>
    <section>
        <div class="card card-outline card-warning">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0">Data Quarry</p>
                    <a href="/admin/quarry/tambah" class="main-button f14">
                        <i class="fa fa-plus mr-1"></i>
                        <span>Tambah</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center f14 no-sort"></th>
                        <th width="5%" class="text-center f14">#</th>
                        <th width="20%" class="f14">Perusahaan</th>
                        <th width="15%" class="f14">Jenis Quarry</th>
                        <th width="20%" class="f14">Kota</th>
                        <th width="20%" class="f14">Provinsi</th>
                        <th width="10%" class="text-center f14">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                        <tr>
                            <td width="5%" class="text-center f14 dt-control">
                                <i class="fa fa-plus-square-o main-text expand-icon"></i>
                            </td>
                            <td width="5%" class="text-center f14">{{ $loop->index + 1 }}</td>
                            <td class="f14">{{ $v->company->name }}</td>
                            <td class="f14">{{ $v->category->name }}</td>
                            <td class="f14">{{ ucwords(strtolower($v->city->name)) }}</td>
                            <td class="f14">{{ ucwords(strtolower($v->city->province->name)) }}</td>
                            <td width="15%" class="text-center">
                                <div class="dropdown">
                                    <a href="#" class="main-button-outline" data-toggle="dropdown">
                                        <span style="font-size: 12px;">Kelola</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                                        <a href="/admin/quarry/{{$v->id}}/edit" class="dropdown-item f12">Edit</a>
                                        <a href="#" data-id="{{ $v->id }}"
                                           class="dropdown-item f12 btn-delete">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        function detailElement(d) {
            return '<div>' +
                '<p class="font-weight-bold">Detail Quarry</p>' +
                '<table cellpadding="5" cellspacing="0" border="0">' +
                '<tr></tr>' +
                '</table>' +
                '</div>';
        }


        $(document).ready(function () {
            var table = $('#table-data').DataTable({
                scrollX: true,
                responsive: true,
            });

            $('#table-data tbody').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var i = $(this).children();
                console.log(i);
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    i.removeClass('fa fa-minus-square-o');
                    i.addClass('fa fa-plus-square-o');
                } else {
                    // Open this row
                    row.child(detailElement(row.data())).show();
                    tr.addClass('shown');
                    i.removeClass('fa fa-plus-square-o');
                    i.addClass('fa fa-minus-square-o');
                    console.log(row.data());
                    // console.log(tr.closest('i'));
                }
            });
        });
    </script>
@endsection
