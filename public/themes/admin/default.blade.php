<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title','titulo')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    @stack('page-links')
</head>
<body>
<header>
    @include('partials.top-menu')
</header>
<main>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12 my-2">
                @include('partials.session_alert')
                @yield('content')
            </div>
        </div>
    </div>
</main>
<footer>
    @include('partials.footer')
    @stack('page-script')
</footer>
</body>
</html>