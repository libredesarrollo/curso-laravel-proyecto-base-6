<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset("js/backend.js") }}"></script>
    <title>Módulo admin</title>
</head>

<body>

    @include('dashboard.partials.nav-header-main')

    <div class="container">
        @include('dashboard.partials.session-flash-status')
        @yield('content')
    </div>
    
</body>

</html>