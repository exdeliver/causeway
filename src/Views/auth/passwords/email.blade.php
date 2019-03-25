@extends('causeway::layouts.site')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <request-password-component
                                csrf_token="{{ csrf_token() }}"
                                request_password_route="{{ route('password.email') }}"
                                login_route="{{ route('login') }}"
                        ></request-password-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
