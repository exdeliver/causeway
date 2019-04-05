@extends('causeway::layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin/authorisation/user/index">Users</a></li>
@stop


@section('content')
    <div class="card">
        <div class="card-header">Users</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')

            <a href="{{ route('admin.authorisation.user.create') }}" class="btn btn-primary float-right">Create Event</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="users-table" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Role</th>
                    <th>Manage</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('ajax.authorisation.users.index') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'role', name: 'role'},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
