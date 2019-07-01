<div class="form-group text-center">
    <label for="ship_different_address">{{ __('Ship to different address') }}?</label>
    {!! Form::checkbox('ship_different_address', 1, null, ['class' => 'form-control input-sm', 'id' => 'ship_different_address', 'style' => 'height: 20px;']) !!}
</div>
<span id="shipping-details"></span>
<p>
<hr class="py-0 my-0 border border-grey-lighter"/>
</p>

<p class="alert alert-info">{{ __('Recipient shipping details') }}</p>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="shipping_first_name">{{ __('First name') }}</label>
        {{ Form::text('shipping_first_name', null, ['class' => 'form-control', 'id' => 'shipping_first_name']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'shipping_first_name'])
    </div>
    <div class="form-group col-md-6">
        <label for="shipping_last_name">{{ __('Last name') }}</label>
        {{ Form::text('shipping_last_name', null, ['class' => 'form-control', 'id' => 'shipping_last_name']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'shipping_last_name'])
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-8">
        <label for="shipping_address">{{ __('Address') }}</label>
        {{ Form::text('shipping_address', null, ['class' => 'form-control', 'id' => 'shipping_address']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'shipping_address'])
    </div>
    <div class="form-group col-md-2">
        <label for="shipping_address_number">{{ __('Number') }}</label>
        {{ Form::text('shipping_address_number', null, ['class' => 'form-control', 'id' => 'shipping_address_number']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'shipping_address_number'])
    </div>
    <div class="form-group col-md-2">
        <label for="shipping_address_suffix">{{ __('Suffix') }}</label>
        {{ Form::text('shipping_address_suffix', null, ['class' => 'form-control', 'id' => 'shipping_address_suffix']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'shipping_address_suffix'])
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-5">
        <label for="shipping_city">{{ __('City') }}</label>
        {{ Form::text('shipping_city', null, ['class' => 'form-control', 'id' => 'shipping_city']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'shipping_city'])
    </div>
    <div class="form-group col-md-5">
        <label for="shipping_country">{{ __('Country') }}</label>
        {{ Form::select('shipping_country', countriesListArray() + ['' => '--- Make selection ---'] ?? [], null, ['class' => 'form-control', 'id' => 'shipping_country']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'shipping_country'])
    </div>
    <div class="form-group col-md-2">
        <label for="shipping_zipcode">{{ __('Zipcode') }}</label>
        {{ Form::text('shipping_zipcode', null, ['class' => 'form-control', 'id' => 'shipping_zipcode']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'shipping_zipcode'])
    </div>
</div>