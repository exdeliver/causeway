@extends('causeway::layouts.site')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <p class="text-center" style="padding-bottom: 0px; margin-bottom: 0px;">
                            <small><a href="http://www.exdeliver.nl" target="_blank">EXdeliver</a> presents...</small>
                        </p>
                        <h1 class="text-center" style="padding-top: 0px; margin-top: 0px;">Causeway CMS</h1>
                        @include('causeway::layouts.partials._status_messages')
                        <login-component
                                csrf_token="{{ csrf_token() }}"
                                request_password_route="{{ route('causeway.password.request') }}"
                                login_route="{{ route('causeway.login') }}"
                                redirect_route="{{ route('causeway.dashboard') }}"
                        ></login-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
