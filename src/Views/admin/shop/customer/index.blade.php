@extends('causeway::layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.customer.index') }}">Customers</a></li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Shop Customers</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')

            <a href="{{ route('admin.shop.customer.create') }}" class="btn btn-primary float-right">Create Customer</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="shop-customer-table" style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Orders</th>
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
            $('#shop-customer-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('ajax.shop.customer.index') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'orders', name: 'orders'},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
