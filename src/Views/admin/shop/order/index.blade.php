@extends('causeway::layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.order.index') }}">Orders</a></li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Shop Orders</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')

            <a href="{{ route('admin.shop.order.create') }}" class="btn btn-primary float-right">Create Order</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="shop-orders-table" style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Created</th>
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
            $('#shop-orders-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('ajax.shop.orders.index') !!}',
                order: [[4, "desc"]],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price'},
                    {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
