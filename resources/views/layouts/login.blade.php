<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Prijava - Obitelj 3Plus</title> 

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700|Raleway:300,600" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" type="image/x-icon">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

    <!-- jQuery & Bootstrap libaries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Login JS -->
    <script src="{{ asset('assets/js/login.js') }}"></script>
	
	<!-- jQuery core library-->
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

    <!-- jQuery and bootstrap notify library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <!-- Bootstrap Notify library -->
    <script src="{{ asset('assets/js/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

</head>

<body>
    <div id="app" class="container">
        @include('partials.success')
        @include('partials.error')
        @yield('content')
    </div>
</body>

</html>