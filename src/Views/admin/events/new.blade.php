@extends('causeway::admin.layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Events</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')
            <h4>Create new event</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::open(['url' => route('admin.events.new.store'), 'id' => 'event-form']) }}
            @include('causeway::admin.events.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection

@push('scripts')

@endpush
