@extends('causeway::auth.layouts.site')

@section('content')
    <div class="sm:w-auto md:w-full lg:w-1/2">
        <div class="border-teal-100 p-8 border-t-12 bg-white mb-6 rounded-lg shadow-lg  mt-1">
            <h2 class="font-hairline mb-6 text-center p-0 mt-1">{{ __('Verify account') }}</h2>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }}, <a href="{{ route('causeway.verification.resend') }}">{{ __('click here to request another') }}</a>.
        </div>
    </div>
@endsection
