@extends('admin.layout')

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
                    <a href="{{ env('PREFIX_URL') }}/admin">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ env('PREFIX_URL') }}/admin/member">Member</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit
                </li>
            </ol>
        </div>
        <section>
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <p class="mb-0">Form Data Member</p>
                </div>
                <div class="card-body">
                    <form method="post">
                        @csrf
                        <div class="w-100 mb-4">
                            <label for="username" class="form-label f14">Username</label>
                            <input type="text" class="form-control f14" id="username" placeholder="Username"
                                   name="username" value="{{ $data->user->username }}" required>
                        </div>
                        <div class="w-100 mb-4">
                            <label for="name" class="form-label f14">Nama</label>
                            <input type="text" class="form-control f14" id="name" placeholder="Nama"
                                   name="name" value="{{ $data->name }}" required>
                        </div>
                        <div class="w-100 mb-4">
                            <label for="phone" class="form-label f14">No. Telp</label>
                            <input type="number" class="form-control f14" id="phone" placeholder="62xxxxxxxx "
                                   name="phone" value="{{ $data->phone }}" required>
                        </div>
                        <hr>
                        <div class="w-100 text-right">
                            <button type="submit" class="main-button f14">
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
