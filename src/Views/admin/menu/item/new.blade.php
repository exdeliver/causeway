@extends('layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Menu</div>

        <div class="card-body">
            @include('layouts.partials._status_messages')
            <h4>Add menu item</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::open(['url' => route('admin.menu.item.store', ['menu' => $menu->id]), 'id' => 'menu-form']) }}
            @include('admin.menu.item.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
