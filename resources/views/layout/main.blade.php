<!doctype html>
<html>
<head>
    <title>Benchmark tests</title>
    <link rel="stylesheet" href="{!! URL::asset('assets/css/app.css') !!}">
</head>
<body>
<div class="container-fluid">
    <div id="app">
        @yield('content-header')
        @yield('content')
    </div>
</div>
<script type="text/javascript" src="{!! URL::asset('assets/js/app.js') !!}"></script>
</body>
</html>
