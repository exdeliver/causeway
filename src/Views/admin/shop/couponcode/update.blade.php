@extends('causeway::layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.couponcode.index') }}">Coupon Codes</a></li>
    <li class="breadcrumb-item">Edit {{ $couponCode->name }}</li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Coupon code</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')
            <h4>Update Coupon code</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::model($couponCode, ['url' => route('admin.shop.couponcode.update.store', ['id' => $couponCode->id]), 'id' => 'category-form', 'method' => 'put']) }}
            @include('causeway::admin.shop.couponcode.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
