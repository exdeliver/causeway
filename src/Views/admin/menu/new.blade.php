@extends('causeway::admin.layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Menu</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')
            <h4>Create new Menu</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::open(['url' => route('admin.menu.new.store'), 'id' => 'menu-form', 'method' => 'post']) }}
            @include('causeway::admin.menu.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
