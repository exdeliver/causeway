@extends('layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin/forum/index">Forum</a></li>
@stop


@section('content')
    <div class="card">
        <div class="card-header">Forum</div>

        <div class="card-body">
            @include('layouts.partials._status_messages')

            <a href="{{ route('admin.forum.create') }}" class="btn btn-primary float-right">Create Category</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="forum-categories-table" style="width:100%">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Subcategory</th>
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
            $('#forum-categories-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('ajax.forum.index') !!}',
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'subcategory', name: 'subcategory'},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
