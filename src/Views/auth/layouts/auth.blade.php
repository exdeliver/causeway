<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ causewayAsset('css/datatables.css') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ causewayAsset('css/app.css') }}" rel="stylesheet">
    <link href="{{ causewayAsset('css/website.css') }}" rel="stylesheet">
    <link href="{{ causewayAsset('css/datatables.css') }}" rel="stylesheet">
    <link href="{{asset('vendor/laraberg/css/laraberg.css')}}" rel="stylesheet">
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body class="bg-grey-lighter h-screen font-sans">
<div class="container mx-auto my-auto h-full flex justify-center items-center" id="app">
    @yield('content')
</div>

<!-- Scripts -->
<script src="/js/lang.js"></script>
<script src="{{ causewayAsset('js/app.js') }}"></script>
<script src="{{ causewayAsset('js/website.js') }}"></script>
<script src="{{ causewayAsset('js/datatables.min.js') }}"></script>
<script src="https://unpkg.com/react@16.6.3/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16.6.3/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/moment@2.22.1/min/moment.min.js"></script>
<script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
@stack('headerScripts')
@stack('scripts')
</body>
</html>
