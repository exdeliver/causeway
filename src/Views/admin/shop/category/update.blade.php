@extends('causeway::layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.category.index') }}">Categories</a></li>
    <li class="breadcrumb-item">Edit {{ $category->title }}</li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Category</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')
            <h4>Update Category</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::model($category, ['url' => route('admin.shop.category.update.store', ['id' => $category->id]), 'id' => 'category-form', 'method' => 'put']) }}
            @include('causeway::admin.shop.category.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
