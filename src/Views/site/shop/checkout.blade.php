@extends('site::layouts.site')

@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route('shop.index') }}">Shop</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('shop.cart') }}">Cart</a></li>
    <li class="breadcrumb-item active">Checkout</li>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 id="cart-title" class="pull-left font-hairline mb-0">{{ __('Shopping Checkout') }}</h1>

                <div class="clearfix"></div>
                <p>
                <hr class="py-0 my-0 border border-grey-lighter"/>
                </p>
                <message-component @status-message="flash('success','test', 'test')"></message-component>
            </div>
            <div class="d-none d-xl-block col-xl-3 bd-toc">
                <ul class="section-nav">
                    <li class="toc-entry toc-h2"><a href="#billing-details">{{ __('Billing details') }}</a></li>
                    <li class="toc-entry toc-h2"><a href="#shipping-details">{{ __('Shipping details') }}</a></li>
                    <li class="toc-entry toc-h2"><a href="#payment-provider">{{ __('Payment provider') }}</a></li>
                    <li class="toc-entry toc-h2"><a href="#overview">{{ __('Overview') }}</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                @include('site::layouts.partials._status_messages')
                <div class="container-fluid" style="padding: 0px !important">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="alert alert-info">
                                {{ __('Please submit your personal information to finish the order process.') }}
                            </p>
                        </div>
                    </div>
                    {{ Form::open(['url' => route('shop.checkout.store'), 'method' => 'post']) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2 border-solid border-grey-light rounded border shadow-sm">
                                <div class="bg-dark px-2 py-3 border-solid border-grey-light border-b text-white">
                                    {{ __('Billing information') }}
                                </div>
                                <div class="p-3 bg-white">
                                    @include('site::shop.partials.checkout._billingInfo')
                                    @include('site::shop.partials.checkout._shippingInfo')
                                    <hr/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            @include('site::shop.partials.checkout._shipping')
                            @include('site::shop.partials.checkout._payment')
                        </div>
                        <div class="col-md-12">
                            @include('site::shop.partials.checkout._totals')
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop