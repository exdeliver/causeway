@extends('causeway::admin.layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.customer.index') }}">Customers</a></li>
    <li class="breadcrumb-item">Edit {{ $customer->full_name }}</li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Customer</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')
            <h4>Update Customer</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::model($category, ['url' => route('admin.shop.customer.new.store'), 'id' => 'customer-form']) }}
            @include('causeway::admin.shop.customer.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
