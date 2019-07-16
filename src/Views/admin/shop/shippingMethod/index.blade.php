@extends('causeway::admin.layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.shipping-method.index') }}">Shipping methods</a></li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Shop Shipping methods</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')

            <a href="{{ route('admin.shop.order.create') }}" class="btn btn-primary float-right">Create Shipping method</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="shop-shipping-method-table" style="width:100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Gross price</th>
                    <th>VAT price</th>
                    <th>Max weight</th>
                    <th>Service</th>
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
            $('#shop-shipping-method-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('ajax.shop.shipping-method.index') !!}',
                order: [[4, "desc"]],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'gross_price', name: 'gross_price'},
                    {data: 'vat_price', name: 'vat_price'},
                    {data: 'max_weight', name: 'max_weight'},
                    {data: 'service', name: 'service'},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
