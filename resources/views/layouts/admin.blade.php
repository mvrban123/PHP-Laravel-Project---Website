<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title') - Obitelj 3Plus</title> 

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">

    <!-- Custom fonts for this template-->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Font awesome icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Animations -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate/animate.css') }}">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">

    <!-- jQuery core library-->
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

    <!-- jQuery and bootstrap notify library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <!-- Bootstrap Notify library -->
    <script src="{{ asset('assets/js/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- Bootstrap data table -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables/dataTables.bootstrap4.min.css') }}"> 

    <!-- Data table -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables/select.bootstrap4.min.css') }}">

    <!-- Data table responsive-->
    <link rel="stylesheet" href="{{ asset('assets/css/datatables/responsive.bootstrap4.min.css') }}">

    @yield('css')
</head>

<body id="page-top">
    <div id="wrapper">
        @include('partials.side-navigation')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('partials.top-navigation')
                @include('partials.success')
                @include('partials.error')
                @yield('content')
            </div>
            <!-- End of Main Content -->
            @include('partials.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/js/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/admin.min.js') }}"></script>

    @yield('js')
</body>

</html>