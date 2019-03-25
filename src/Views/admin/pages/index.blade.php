@extends('layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin/pages/index">Pages</a></li>
@stop


@section('content')
    <div class="card">
        <div class="card-header">Pages</div>

        <div class="card-body">
            @include('layouts.partials._status_messages')

            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary float-right">Create Page</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="pages-table" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>URL</th>
                    <th>Access level</th>
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
            $('#pages-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('ajax.pages.index') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'url', name: 'url'},
                    {data: 'access_level', name: 'access_level'},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
