@extends('causeway::layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Users</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')
            <h4>Create new user</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::open(['url' => route('admin.authorisation.role.store'), 'id' => 'user-form']) }}
            @include('causeway::admin.authorisation.users.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection

@push('scripts')

@endpush
