@extends('causeway::admin.layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Menu</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')
            <h4>Update Menu</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::model($menu, ['url' => route('admin.menu.new.store'), 'id' => 'menu-form']) }}
            @include('causeway::admin.menu.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
