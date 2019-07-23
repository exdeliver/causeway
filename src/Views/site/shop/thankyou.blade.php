@extends('site::layouts.site')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 id="cart-title" class="pull-left font-hairline mb-0">{{ __('Order') }}</h1>

                <div class="clearfix"></div>
                <p>
                <hr class="py-0 my-0 border border-grey-lighter"/>
                </p>
                <message-component @status-message="flash('success','test', 'test')"></message-component>
            </div>
            <div class="col-md-12">
                @include('site::layouts.partials._status_messages')
                <div class="container-fluid" style="padding: 0px !important">
                    <div class="row">
                        <div class="col-md-12">
                            @include('site::shop.partials.thankyou._payment_status')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop