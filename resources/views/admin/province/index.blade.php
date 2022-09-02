@extends('admin.layout')

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
                <li class="breadcrumb-item active" aria-current="page">Provinsi
                </li>
            </ol>
        </div>
    </div>
    <section>
        <div class="card">
            <div class="card-header bg-main">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0"><i class="fa fa-map mr-2"></i>Data Provinsi</p>
                    <a href="/admin/provinsi/tambah" class="main-button-sm" style="font-size: 16px;">
                        <i class="fa fa-plus mr-1"></i>
                        {{--                        <span>Tambah</span>--}}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="table-data" class="display w-100 table table-bordered">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center f14">#</th>
                        <th class="f14">Nama</th>
                        <th width="10%" class="text-center f14"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                        <tr>
                            <td width="5%" class="text-center f14">{{ $loop->index + 1 }}</td>
                            <td class="f14">{{ ucwords(strtolower($v->name)) }}</td>
                            <td width="15%" class="text-center">
                                <a href="#" class="main-button-outline">
                                    <span style="font-size: 12px;">Kelola</span></a>
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
        $(document).ready(function () {
            $('#table-data').DataTable({
                "scrollX": true
            });
        });
    </script>
@endsection
