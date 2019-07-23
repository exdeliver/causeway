@extends('causeway::admin.layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.order.index') }}">Orders</a></li>
    <li class="breadcrumb-item">Order {{ $order->id }}</li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Order {{ $order->id }}</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')

            @include('causeway::admin.shop.order.partials._order_status')
            <hr/>
            @include('causeway::admin.shop.order.partials._payment_details')
            <hr/>
            @include('causeway::admin.shop.order.partials._customer_details')

            @include('causeway::admin.shop.order.partials._order_products')

            @include('causeway::admin.shop.order.partials._order_audit')

            <a href="{{ route('shop.order.invoice', ['id' => $order->uuid]) }}" class="btn btn-outline-dark" target="_blank"><i class="fa fa-file-pdf-o"></i> Invoice </a>
        </div>
    </div>
@endsection