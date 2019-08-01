<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($metaTitle) ? $metaTitle . ' - ' : null }}{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ causewayAsset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">

    <script>
        window.Laravel =; <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    @stack('topscripts')
</head>
<body>
<div id="app">
    @include('site::layouts.partials._navigation')

    <main class="py-4">
        @include('site::layouts.partials._breadcrumbs')
        @yield('content')
    </main>
</div>

<!-- Scripts -->
<script src="/js/lang.js"></script>
<script src="{{ causewayAsset('js/app.js') }}"></script>
<script src="{{ causewayAsset('js/website.js') }}"></script>
<script src="{{ causewayAsset('js/datatables.min.js') }}"></script>
@stack('headerScripts')
@stack('scripts')
</body>
</html>
