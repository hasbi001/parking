<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Parkir</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content='parkir'>
        <meta name="keywords" content="parkir">
        
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="{{ asset('assets/css/jquery.datetimepicker.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
        </head>
    <body>
        <div id="app">
            <main class="container-fluid">
                @yield('content')
            </main>
            <!-- Scripts -->
            <!-- <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script> -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
            <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
            <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
            <script src="{{ asset('assets/js/jquery.datetimepicker.full.min.js') }}"></script>
            <script src="{{ asset('assets/js/app.js') }}"></script>
            @yield('js')
        </div>
    </body>
</html>