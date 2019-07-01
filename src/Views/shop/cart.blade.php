@extends('causeway::layouts.site')

@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route('shop.index') }}">Shop</a></li>
    <li class="breadcrumb-item active">Cart</li>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 id="cart-title" class="pull-left font-hairline mb-0">{{ __('Shopping Cart') }}</h1>
                <a href="{{ route('shop.index') }}" class="btn btn-primary pull-right">{{ __('Continue shopping') }}</a>
                <a href="{{ route('shop.cart.clear') }}" class="btn btn-outline-dark pull-right mr-2">{{ __('Clear cart') }}</a>
                <div class="clearfix"></div>
                <p>
                <hr class="py-0 my-0 border border-grey-lighter"/>
                </p>
                <message-component @status-message="flash('success','test', 'test')"></message-component>
                @include('causeway::layouts.partials._status_messages')
                <div class="container-fluid" style="padding: 0px !important">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="mb-2 border-solid border-grey-light rounded border shadow-sm">
                                <div class="p-3 bg-white">
                                    <p>
                                        @include('causeway::layouts.partials.common._error', ['name' => 'cart'])
                                    </p>
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <tr class="first last">
                                            <th width="50%">
                                                <span>{{ __('Product') }}</span>
                                            </th>
                                            <th class="text-center" width="30%">
                                                {{ __('Quantity') }}
                                            </th>
                                            <th></th>
                                            <th class="text-center cart-total-head" width="10%">
                                                {{ __('Total') }}
                                            </th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($products as $product)
                                            <tr is="cart-component" :product="{{ json_encode($product) }}"
                                                add_to_cart_route="{{ route('shop.product.add_to_cart') }}"></tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <p><strong>{{ __('Shopping cart is empty') }}</strong></p>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            @include('causeway::shop.partials.cart._totals')
                            @include('causeway::shop.partials.cart._couponCode')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop