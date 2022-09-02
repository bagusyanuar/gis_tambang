@extends('admin.layout')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p class="font-weight-bold mb-0" style="font-size: 20px">Provinsi</p>
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
        <div class="w-100 text-right">
            <a href="/admin/provinsi/tambah" class="main-button">
                <i class="fa fa-plus mr-1"></i>
                <span>Tambah</span>
            </a>
        </div>
        <hr class="mt-4">
        <table id="table-data" class="display w-100 table table-bordered">
            <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th>Nama</th>
                <th width="10%" class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $v)
                <tr>
                    <td width="5%" class="text-center">{{ $loop->index + 1 }}</td>
                    <td>{{ $v->name }}</td>
                    <td width="15%" class="text-center">
                        <a href="#" class="info-button-sm"><i class="fa fa-edit"></i></a>
                        <a href="#" class="danger-button-sm"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
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
