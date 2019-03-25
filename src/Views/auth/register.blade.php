@extends('layouts.site')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <register-component
                                csrf_token="{{ csrf_token() }}"
                                register_route="{{ route('register') }}"
                                login_route="{{ route('login') }}"></register-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
