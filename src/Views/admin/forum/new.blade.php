@extends('layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Forum</div>

        <div class="card-body">
            @include('layouts.partials._status_messages')
            <h4>Create new category</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::open(['url' =>route('admin.forum.new.store'), 'files' => 'true', 'id' => 'forum-form']) }}
            @include('admin.forum.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection
