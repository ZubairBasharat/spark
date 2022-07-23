<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta author="Mian Roshan" content="Full Stack developer" />
    <title>Spark&nbsp;|&nbsp;Home</title>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libraries/bootstrap/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/main.css?v=1')}}" />
    <link rel="icon" href="{{asset('assets/images/favicon-large.png')}}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{asset('assets/images/favicon.png')}}" />
    <script type="text/javascript" src="{{asset('assets/libraries/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/libraries/bootstrap/bootstrap.bundle.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/main.min.js')}}"></script>

    @yield('scripts')
</head>

<body>
    <div class="main-app-wrap">
        @include('components.header')
        <div>
            @yield('content')
        </div>
        @include('components.footer')
    </div>
</body>

</html>

<body>