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
    <div class="container bg-white">
        <div class="row">
            <div class="col-4 pull-left">
                <p><br/>
                <h3>{{ $companyInformation->company }}</h3>
                </p>
                <p>
                    {{ __('Chambre of commerce') }}: {{ $companyInformation->coc_no }}<br>
                    {{ __('VAT') }}: {{ $companyInformation->vat_no }}<br>
                    {{ __('Address') }}: {{ $companyInformation->address }}<br>
                    {{ __('City') }}: {{ $companyInformation->city ?? '' }}<br>
                    {{ __('Zipcode') }}: {{ $companyInformation->zipcode ?? '' }}<br>
                    {{ __('Country') }}: {{ $companyInformation->country ?? '' }}<br>
                </p>
            </div>
            <div class="col-8 pull-left"></div>
            <div class="clearfix"></div>
        </div>
    </div>
    @yield('content')
    <div class="container bg-white">
        <div class="row">
            <div class="col-12 pull-left" style="font-size: 10px;">
                <ul class="p-0 m-0 pull-left">
                    <li class="pull-left">{{ $companyInformation->company }}&nbsp;|&nbsp;</li>
                    <li class="pull-left">{{ __('Chamber of commerce') }} {{ $companyInformation->coc_no }}&nbsp;|&nbsp;</li>
                    <li class="pull-left">{{ __('VAT') }} {{ $companyInformation->vat_no }}&nbsp;|&nbsp;</li>
                    <li class="pull-left">{{ __('E-mail') }} {{ $companyInformation->email }}&nbsp;|&nbsp;</li>
                    <li class="pull-left">{{ __('Bank') }} {{ $companyInformation->bank_account }} {{ $companyInformation->bank_name }}&nbsp;|&nbsp;</li>
                    <li class="pull-left">WWW {{ config('app.url') }}</li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<!-- Scripts -->
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
