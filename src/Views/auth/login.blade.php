@extends('causeway::layouts.auth')

@section('content')
        <div class="sm:w-auto md:w-full lg:w-1/2">
            <div class="border-teal-100 p-8 border-t-12 bg-white mb-6 rounded-lg shadow-lg  mt-1">
                <p class="text-center font-hairline m-0">
                    <small><a href="http://www.exdeliver.nl" target="_blank">EXdeliver</a> presents...</small>
                </p>
                <h4 class="font-hairline mb-6 text-center p-0 m-0">Causeway CMS</h4>
                <h2 class="font-hairline mb-6 text-center p-0 mt-1">{{ __('Login') }}</h2>
                @include('causeway::layouts.partials._status_messages')
                <login-component
                        csrf_token="{{ csrf_token() }}"
                        request_password_route="{{ route('causeway.password.request') }}"
                        login_route="{{ route('causeway.login') }}"
                        redirect_route="{{ route('causeway.dashboard') }}"
                ></login-component>
            </div>
            <div class="text-center">
                <p class="text-grey-dark text-sm">Created by <a href="http://exdeliver.nl" class="no-underline text-blue font-bold" target="_blank">EXdeliver V.O.F.</a>.</p>
            </div>
        </div>
@endsection
