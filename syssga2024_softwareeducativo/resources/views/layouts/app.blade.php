<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $empresa_ini->nomEmp }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style type="text/css">
        .image-container {
          background-image: url('../empresa/portada.png');
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;
          width: 100%;
          height: 100vh;
          padding-bottom: 75%; /* Proporción de aspecto deseada (ejemplo: 4:3 = 75%) */
        }


       
    </style>
</head>
<body>
    <div id="app">
        <main class="py-4 bg-primary image-container">
            @yield('content')
        </main>
    </div>
</body>
</html>
