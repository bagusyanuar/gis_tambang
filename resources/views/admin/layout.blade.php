<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/adminlte/css/adminlte.min.css')}}">
    <link href="{{ asset('/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js')}}"></script>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <title>Document</title>
    @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<nav class="main-header navbar navbar-expand elevation-1">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link navbar-link-item" data-widget="pushmenu" href="#" role="button"><i
                    class="fa fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link navbar-link-item" data-toggle="dropdown" href="#">
                <i class="fa fa-user mr-2"></i>
                <span>{{ auth()->user()->username }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item navbar-link-item">
                    <i class="fa fa-power-off mr-2"></i>Keluar</a>
            </div>
        </li>
    </ul>
</nav>
<aside class="main-sidebar sidebar-dark-primary elevation-1">
    <div class="sidebar">
        <a href="/admin" class="brand-link">
            <img src="{{ asset('assets/icons/logo-short.png') }}" style="width: 34px !important;"
                 alt="AdminLTE Logo"
                 class="brand-image text-center"
            >
            <span class="brand-text font-weight-light">GIS</span>
        </a>
        <div class="my-sidebar-menu">
            <ul class="nav nav-sidebar nav-pills flex-column">
                <nav class="mt-2 nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                     data-accordion="false">
                    <li class="nav-item">
                        <a href="/admin"
                           class="nav-link {{ \Illuminate\Support\Facades\Request::path() == 'admin' ? 'active' : ''}}">
                            <i class="fa fa-tachometer nav-icon" aria-hidden="true"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/provinsi"
                           class="nav-link {{ \Illuminate\Support\Facades\Request::path() == 'admin/provinsi' ? 'active' : ''}}">
                            <i class="fa fa-map nav-icon" aria-hidden="true"></i>
                            <p>Provinsi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/kota"
                           class="nav-link {{ \Illuminate\Support\Facades\Request::path() == 'admin/kota' ? 'active' : ''}}">
                            <i class="fa fa-map-marker nav-icon" aria-hidden="true"></i>
                            <p>Kota</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{ str_contains(\Illuminate\Support\Facades\Request::path(), 'pengaduan') ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link {{ str_contains(\Illuminate\Support\Facades\Request::path(), 'pengaduan') ? 'active' : ''}}">
                            <i class="nav-icon fa fa-bell"></i>
                            <p>
                                Pengaduan
                                <i class="right fa fa-angle-down"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/admin/pengaduan/menunggu"
                                   class="nav-link {{ \Illuminate\Support\Facades\Request::path() == 'admin/pengaduan/menunggu' ? 'active' : ''}}">
                                    <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                    <p>Menunggu</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/pengaduan/terima"
                                   class="nav-link {{ \Illuminate\Support\Facades\Request::path() == 'admin/pengaduan/terima' ? 'active' : ''}}">
                                    <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                    <p>Terima</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/pengaduan/tolak"
                                   class="nav-link {{ \Illuminate\Support\Facades\Request::path() == 'admin/pengaduan/tolak' ? 'active' : ''}}">
                                    <i class="fa fa-circle-o nav-icon" aria-hidden="true"></i>
                                    <p>Tolak</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </nav>
            </ul>
        </div>
    </div>
</aside>
<div class="content-wrapper p-3">
    @yield('content-title')
    @yield('content')
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="{{ asset ('/adminlte/js/adminlte.js') }}"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('/datatables/dataTables.bootstrap4.min.js') }}"></script>
@yield('js')
</body>
</html>
