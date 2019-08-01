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
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ])  !!};
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('causeway.login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('causeway.register') }}">{{ __('Register') }}</a>
                            @endif
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('causeway.logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('causeway.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if(request()->is('causeway/*'))
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        @include('causeway::admin.layouts.admin.partials._sidebar')
                    </div>
                    <div class="col-lg-9">
                        @yield('content')
                    </div>
                </div>
            </div>
        @else
            @yield('content')
        @endif
    </main>
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
