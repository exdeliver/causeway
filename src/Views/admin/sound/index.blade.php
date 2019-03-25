@extends('layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/admin/sound/index">Sounds</a></li>
@stop


@section('content')
    <div class="card">
        <div class="card-header">Sounds</div>

        <div class="card-body">
            @include('layouts.partials._status_messages')

            <a href="{{ route('admin.sound.create') }}" class="btn btn-primary float-right">Create Sound</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="sounds-table" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Artist</th>
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
                ajax: '{!! route('ajax.sound.index') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'artist', name: 'artist'},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
