@extends('causeway::admin.layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Sounds</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')
            <h4>Update sound {{ $sound->name }}</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::model($sound, ['url' => route('admin.sound.update.store', ['id' => $sound->id]), 'id' => 'sound-form', 'method' => 'put']) }}
            @include('causeway::admin.sound.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
