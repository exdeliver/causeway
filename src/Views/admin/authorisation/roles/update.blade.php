@extends('causeway::admin.layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Role</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')
            <h4>Update role {{ $role->name }}</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::model($role, ['url' => route('admin.authorisation.role.update.store', ['id' => $role->id]), 'id' => 'user-form', 'method' => 'PUT']) }}
            @include('causeway::admin.authorisation.roles.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection

@push('scripts')

@endpush
