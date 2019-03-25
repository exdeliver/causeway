@extends('layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin/Menu/index">Menu</a></li>
@stop


@section('content')
    <div class="card">
        <div class="card-header">Menu</div>

        <div class="card-body">
            @include('layouts.partials._status_messages')

            <a href="{{ route('admin.menu.create') }}" class="btn btn-primary float-right">Create Menu</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="menu-table" style="width:100%">
                <thead>
                <tr>
                    <th>Label</th>
                    <th>Name</th>
                    <th>Items</th>
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
            $('#menu-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('ajax.menu.index') !!}',
                columns: [
                    {data: 'label', name: 'label'},
                    {data: 'name', name: 'name'},
                    {data: 'items', name: 'items'},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
