@extends('causeway::layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.product.index') }}">Products</a></li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Shop Products</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')

            <a href="{{ route('admin.shop.product.create') }}" class="btn btn-primary float-right">Create Product</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="shop-products-table" style="width:100%">
                <thead>
                <tr>
                    <th>PID</th>
                    <th>Name</th>
                    <th>Gross Price</th>
                    <th>VAT Price</th>
                    <th>VAT</th>
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
            $('#shop-products-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('ajax.shop.product.index') !!}',
                columns: [
                    {data: 'pid', name: 'pid'},
                    {data: 'name', name: 'name'},
                    {data: 'gross_price', name: 'gross_price'},
                    {data: 'vat_price', name: 'vat_price'},
                    {data: 'vat', name: 'vat'},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
