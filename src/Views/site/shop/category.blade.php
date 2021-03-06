@extends('site::layouts.site')

@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route('shop.index') }}">Shop</a></li>
    <li class="breadcrumb-item active">Category</li>
    <li class="breadcrumb-item active">{{ $category->title }}</li>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 id="cart-title" class="pull-left font-hairline mb-0">{{ $category->title }}</h1>
                <div class="clearfix"></div>
                {!! $category->description !!}
                <p>
                <hr class="py-0 my-0 border border-grey-lighter"/>
                </p>

                <message-component @status-message="flash('success','test', 'test')"></message-component>

                @include('site::layouts.partials._status_messages')

                <div class="container-fluid">
                    {{ Form::open(['method' => 'GET']) }}
                    <div class="row">
                        @foreach($activeFilters->chunk(6) as $filterItems)
                            @foreach($filterItems as $filter)
                                <div class="col-md-{{ 12/6 }}">
                                    {!! $filter !!}
                                </div>
                            @endforeach
                        @endforeach
                        <p class="mt-2">
                            <br />
                            {{ Form::submit('Filter', ['class' => 'btn btn-xs btn-primary btn-inline']) }}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr/>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                <div class="container-fluid" style="padding: 0px !important">
                    <div class="pull-left">
                        <p><span><strong>{{ __('Total products') }}:</strong> {{{ $products->total() }}} | <strong>{{ __('Per page') }}:</strong> {{{ $products->perPage() }}}</span></p>
                    </div>
                    <div class="pull-right">
                        {!! $products->appends($activeFilters->toArray())->render() !!}
                    </div>
                    <div class="clearfix"></div>
                    @if(count($products))
                        @foreach($products->chunk($numberOfColumns ?? 4) as $items)
                            <div class="row">
                                @foreach($items as $item)
                                    @include('site::shop.partials.category._product', [
                                        'product' => $item
                                    ])
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        <p><strong>No products</strong></p>
                    @endif
                    <p>
                    <hr class="py-0 my-0 border border-grey-lighter"/>
                    </p>
                    <div class="clearfix"></div>
                    <div class="pull-left">
                        {!! $products->appends($activeFilters->toArray())->render() !!}
                    </div>
                    <div class="pull-right">
                        <p><span><strong>{{ __('Total products') }}:</strong> {{{ $products->total() }}} | <strong>{{ __('Per page') }}:</strong> {{{ $products->perPage() }}}</span></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@stop