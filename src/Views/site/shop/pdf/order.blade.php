@extends('site::layouts.pdf')

@section('content')
    <div class="container bg-white">
        <div class="row">
            <div class="col-3 pull-left">
                <div class="card border-left-info py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Order ID</div>
                                <div class="h5 mb-0 font-weight-bold text-info">{!! $order->id !!}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-file-pdf-o fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3 pull-left">
                <div class="card border-left-info py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Payment status</div>
                                <div class="h5 mb-0 font-weight-bold text-info">{!! $order->is_paid ? 'PAID' : 'UNPAID' !!}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-euro fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-3 pull-left">
                <div class="card border-left-info py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Order status</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $order->status_format }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-bell fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-3 pull-left">
                <div class="card border-left-warning py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Order date</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ causewayDate($order->created_at, 'j M Y H:i') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row">
            <div class="col-12 pull-left">
                <hr/>
            </div>
        </div>

        <div class="row">
            <div class="col-12 pull-left">
                @include('site::shop.partials.order._customer_details')
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row">
            <div class="col-12 pull-left">
                @include('site::shop.partials.order._order_products')
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection