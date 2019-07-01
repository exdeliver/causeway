@extends('causeway::layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.category.index') }}">Categories</a></li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Shop Categories</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')

            <a href="{{ route('admin.shop.category.create') }}" class="btn btn-primary float-right">Create Category</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="forum-categories-table" style="width:100%">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Subcategories</th>
                    <th>Products</th>
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
                ajax: '{!! route('ajax.shop.category.index') !!}',
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'subcategory', name: 'subcategory'},
                    {data: 'products', name: 'products'},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
