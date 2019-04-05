@extends('causeway::layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Users</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')
            <h4>Update user {{ $user->name }}</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::model($user, ['url' => route('admin.authorisation.user.update.store', ['id' => $user->id]), 'id' => 'user-form', 'method' => 'PUT']) }}
            @include('causeway::admin.authorisation.users.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection

@push('scripts')

@endpush
