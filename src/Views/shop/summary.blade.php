@extends('causeway::layouts.site')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 id="cart-title" class="pull-left font-hairline mb-0">{{ __('Checkout Summary') }}</h1>

                <div class="clearfix"></div>
                <p>
                <hr class="py-0 my-0 border border-grey-lighter"/>
                </p>
                <message-component @status-message="flash('success','test', 'test')"></message-component>
            </div>
            <div class="col-md-12">
                @include('causeway::layouts.partials._status_messages')
                <div class="container-fluid" style="padding: 0px !important">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="alert alert-info">
                                {{ __('Please verify your details below.') }}
                            </p>
                        </div>
                    </div>
                    <p><a href="{{ $payment_link }}" class="btn btn-success">{{ __('Make payment') }}</a></p>

                    @include('causeway::shop.partials.summary._order_products')

                    <p><a href="{{ $payment_link }}" class="btn btn-success">{{ __('Make payment') }}</a></p>
                </div>
            </div>
        </div>
    </div>
@stop