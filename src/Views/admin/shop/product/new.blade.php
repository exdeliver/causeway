@extends('causeway::layouts.backend')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.dashboard') }}">Shop</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.shop.product.index') }}">Products</a></li>
    <li class="breadcrumb-item">New</li>
@stop

@section('content')
    <div class="card">
        <div class="card-header"><strong>{{ ucfirst($productType) }}</strong> Product</div>

        <div class="card-body">
            @include('causeway::layouts.partials._status_messages')
            <h4>Create new Product</h4>
            <div class="clearfix"></div>

            <hr/>

            {{ Form::open(['url' => route('admin.shop.product.new.store'), 'id' => 'customer-form', 'method' => 'post']) }}
            @include('causeway::admin.shop.product.partials._form')
            {{ Form::close() }}

        </div>
    </div>
@endsection

@push('scripts')
    <script type="application/javascript">
        $(document).ready(function () {
            $('#summernote').summernote({
                callbacks: {
                    onImageUpload: function (files) {
                        url = '{{ route('site.upload') }}'; //path is defined as data attribute for  textarea
                        sendFile(files[0], url, $(this));

                    }
                }
            });
        });
    </script>
@endpush