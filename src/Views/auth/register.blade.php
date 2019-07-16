@extends('causeway::auth.layouts.auth')

@section('content')
    <div class="sm:w-auto md:w-full lg:w-1/2">
        <div class="border-teal-100 p-8 border-t-12 bg-white mb-6 rounded-lg shadow-lg  mt-1">
            <h2 class="font-hairline mb-6 text-center p-0 mt-1">{{ __('Create account') }}</h2>

            <register-component
                    csrf_token="{{ csrf_token() }}"
                    register_route="{{ route('causeway.register') }}"
                    login_route="{{ route('causeway.login') }}"></register-component>

        </div>
    </div>
@endsection
