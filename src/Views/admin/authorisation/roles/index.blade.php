@extends('causeway::layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin/authorisation/role/index">Roles</a></li>
@stop


@section('content')
    <div class="card">
        <div class="card-header">Roles</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')

            <a href="{{ route('admin.authorisation.role.create') }}" class="btn btn-primary float-right">Create Role</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="roles-table" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
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
            $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('ajax.authorisation.roles.index') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
