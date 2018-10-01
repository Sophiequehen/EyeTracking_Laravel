<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Favicon -->
    <!-- <link rel="shortcut icon" type="image/png" href="/img/favicon.png"/> -->
    
    <link rel="shortcut icon" href="/img/favicon.ico" />
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
    <link rel="icon" type="image/png" href="/img/favicon.png" />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="/css/app.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <!-- If we are connected -->
    @auth
    <div id="content" class="content">
        <header>
            @include('layout/nav_auth')
            @include('layout/navbar')
        </header>
        @yield('content')
    </div>
    
    @else
    @include('auth/login')
    @endauth

    <!-- copyright -->
    <p id="copyright" class="copyright">©CALYXEN</p>

    <script src="/js/app.js"></script>
    @yield('extraJS')
</body>
</html>
