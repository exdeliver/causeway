@extends('causeway::auth.layouts.auth')

@section('content')
    <div class="sm:w-auto md:w-full lg:w-1/2">
        <div class="border-teal-100 p-8 border-t-12 bg-white mb-6 rounded-lg shadow-lg  mt-1">
            <h2 class="font-hairline mb-6 text-center p-0 mt-1">{{ __('Reset password') }}</h2>
            <request-password-component
                    csrf_token="{{ csrf_token() }}"
                    request_password_route="{{ route('causeway.password.email') }}"
                    login_route="{{ route('causeway.login') }}"
            ></request-password-component>
        </div>
    </div>
@endsection
