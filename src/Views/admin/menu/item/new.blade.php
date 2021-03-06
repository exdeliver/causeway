@extends('causeway::admin.layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Menu</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')
            <h4>Add menu item</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::open(['url' => route('admin.menu.item.store', ['menu' => $menu->id]), 'id' => 'menu-form']) }}
            @include('causeway::admin.menu.item.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
