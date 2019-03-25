@extends('layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Forum</div>

        <div class="card-body">
            @include('layouts.partials._status_messages')
            <h4>Update category {{ $category->title }}</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::model($category, ['url' => route('admin.forum.update.store', ['id' => $category->id]), 'id' => 'page-form', 'method' => 'put']) }}
            @include('admin.forum.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
