@extends('layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Menu</div>

        <div class="card-body">
            @include('layouts.partials._status_messages')
            <h4>Update menu item</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::model($item, ['url' => route('admin.menu.item.update', ['menu' => $menu->id, 'item' => $item->id]), 'id' => 'menu-form', 'method' => 'put']) }}
            @include('admin.menu.item.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
