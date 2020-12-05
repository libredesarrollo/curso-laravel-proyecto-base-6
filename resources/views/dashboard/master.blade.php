<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset("dashboard/css/material-dashboard.css") }}">
    <link rel="stylesheet" href="{{ asset("dashboard/demo/demo.css") }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Módulo admin</title>
</head>

<body>

    {{-- @include('dashboard.partials.nav-header-main') --}}

    <div class="wrapper">
        @include('dashboard.partials.sidebar')
        <div class="main-panel">

            @include('dashboard.partials.nav-header-main')

            <div class="content">
                <div class="container-fluid">
                    <div class="container-fluid">
                        @include('dashboard.partials.session-flash-status')
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset("js/backend.js") }}"></script>
    <script src="{{ asset("dashboard/js/core/bootstrap-material-design.min.js") }}"></script>
    <script src="{{ asset("dashboard/js/material-dashboard.js") }}"></script>

</body>

</html>