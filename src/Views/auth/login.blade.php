@extends('causeway::layouts.site')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        @include('causeway::layouts.partials._status_messages')
                        <login-component
                                csrf_token="{{ csrf_token() }}"
                                request_password_route="{{ route('causeway.password.request') }}"
                                login_route="{{ route('causeway.login') }}"
                        ></login-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
