@extends('causeway::admin.layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.order.index') }}">Orders</a></li>
    <li class="breadcrumb-item">New</li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Update order #{{ $order->id }}</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')

            @include('causeway::admin.shop.order.partials._customer_details')

            {{ Form::model($order) }}

            <order-item-component :products="{{ $order->items->toJson() }}"></order-item-component>

            {{ Form::submit('Save', ['class' => 'btn btn-primary pull-right']) }}

            {{ Form::close() }}
        </div>
    </div>
@endsection
