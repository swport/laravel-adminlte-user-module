<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | {{ config('app.name', 'PRTree') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/fontawesome/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    @yield('styles')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        @section('navbar')
            @include('layouts.partials.admin.navbar')
        @show

        @section('leftbar')
            @include('layouts.partials.admin.leftbar')
        @show

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center">
                                <h1 class="m-0">
                                    @section('pageheader')
                                        Dashboard
                                    @show
                                </h1>
                                <div class="ml-3">
                                    @yield('pageheader__actions')
                                </div>
                            </div>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                @section('pagebreads')
                                    <li class="breadcrumb-item active">Dashboard</li>
                                @show
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <div class="content">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-6">
                        @if($errors->any())
                            {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">:message</div>')) !!}
                        @endif
                    </div>
                </div>

                @yield('content')
            </div>
        </div>
        <!-- /.content-wrapper -->

        @section('rightbar')
            @include('layouts.partials.admin.rightbar')
        @show

        @section('footer')
            @include('layouts.partials.admin.footer')
        @show
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <!-- Sweet Alert 2 -->
    <script src="{{ asset('js/sweetalert2@10.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var Toaster = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: function(toast) {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                    toast.addEventListener('click', Swal.close);
                }
            });

            @if( Session::has('success') )
                Toaster.fire({
                    icon: 'success',
                    title: "{{ Session::pull('success') }}"
                });
            @elseif( Session::has('error') )
                Toaster.fire({
                    icon: 'error',
                    title: "{{ Session::pull('error') }}"
                });
            @elseif( Session::has('info') )
                Toaster.fire({
                    icon: 'info',
                    title: "{{ Session::pull('info') }}"
                });
            @endif
        });
    </script>

    @yield('scripts')
</body>

</html>
