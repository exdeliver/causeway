@extends('causeway::layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.couponcode.index') }}">Coupon Codes</a></li>
    <li class="breadcrumb-item">New</li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Coupon code</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')
            <h4>Create new Coupon Code</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::open(['url' => route('admin.shop.couponcode.new.store'), 'id' => 'couponcode-form', 'method' => 'post']) }}
            @include('causeway::admin.shop.couponcode.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
