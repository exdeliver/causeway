@extends('site::layouts.site')

@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route('shop.index') }}">Shop</a></li>
    <li class="breadcrumb-item active">Category</li>
    <li class="breadcrumb-item active">{{ $product->title }}</li>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 id="cart-title" class="pull-left font-hairline mb-0">{{ $product->title }}</h1>

                <div class="clearfix"></div>
                <p>
                <hr class="py-0 my-0 border border-grey-lighter"/>
                </p>
                <message-component @status-message="flash('success','test', 'test')"></message-component>
            </div>
            <div class="col-md-12">
                @include('site::layouts.partials._status_messages')
                <div class="container-fluid bg-white" style="padding: 0px !important">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="row wow fadeIn">

                                <div class="col-md-6 mb-4">

                                    @include('site::shop.partials.product-details._product_image')

                                </div>

                                <div class="col-md-6 mb-4">

                                    <div class="p-4">

                                        @include('site::shop.partials.product-details._badges')

                                        @include('site::shop.partials.product-details._pricing')

                                        @include('site::shop.partials.product-details._description')

                                        <p>
                                        <hr class="py-0 my-0 border border-grey-lighter"/>
                                        </p>

                                        @if($product->type !== \Exdeliver\Causeway\Domain\Entities\Shop\Product::BOOKING_PRODUCT['type'])
                                            <add-to-cart-component show_quantity_input="{{ true }}"
                                                                   csrf_token="{{ csrf_token() }}"
                                                                   add_to_cart_route="{{ route('shop.product.add_to_cart') }}"
                                                                   :product="{{ $product->toJson() }}">
                                            </add-to-cart-component>
                                        @endif

                                    </div>

                                </div>

                            </div>

                            <hr>
                            @if($product->type === \Exdeliver\Causeway\Domain\Entities\Shop\Product::BOOKING_PRODUCT['type'])
                                @include('site::shop.partials.product-details._booking')
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop