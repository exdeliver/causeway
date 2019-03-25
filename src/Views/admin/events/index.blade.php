@extends('causeway::layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin/events/index">Events</a></li>
@stop


@section('content')
    <div class="card">
        <div class="card-header">Events</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')

            <a href="{{ route('admin.events.create') }}" class="btn btn-primary float-right">Create Event</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="events-table" style="width:100%">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Manage</th>
                </tr>
                </thead>
            </table>

            <hr/>
            {!! $calendar->calendar() !!}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#events-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('ajax.events.index') !!}',
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'start_datetime', name: 'start_datetime', searchable: false},
                    {data: 'end_datetime', name: 'end_datetime', searchable: false},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
    {!! $calendar->script() !!}
@endpush
