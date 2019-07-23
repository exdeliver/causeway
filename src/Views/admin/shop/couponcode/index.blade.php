@extends('causeway::admin.layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.couponcode.index') }}">Coupon codes</a></li>
@stop

@section('content')
    <div class="card">
        <div class="card-header">Shop Coupon codes</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')

            <a href="{{ route('admin.shop.couponcode.create') }}" class="btn btn-primary float-right">Create Coupon code</a>
            <div class="clearfix"></div>

            <hr/>
            <table class="table table-bordered display nowrap" id="shop-couponcode-table" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Coupon Code</th>
                    <th>Status</th>
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
            $('#shop-couponcode-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{!! route('ajax.shop.couponcode.index') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'coupon_code', name: 'coupon_code'},
                    {data: 'status', name: 'status'},
                    {data: 'manage', name: 'manage'},
                ]
            });
        });
    </script>
@endpush
