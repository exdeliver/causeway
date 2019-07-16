@extends('causeway::admin.layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.category.index') }}">Categories</a></li>
    <li class="breadcrumb-item">New</li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Category</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')
            <h4>Create new Category</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::open(['url' => route('admin.shop.category.new.store'), 'id' => 'category-form', 'method' => 'post']) }}
            @include('causeway::admin.shop.category.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
