<span id="billing-details"></span>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="first_name">{{ __('First name') }}</label>
        {{ Form::text('first_name', null, ['class' => 'form-control', 'id' => 'first_name']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'first_name'])
    </div>
    <div class="form-group col-md-6">
        <label for="last_name">{{ __('Last name') }}</label>
        {{ Form::text('last_name', null, ['class' => 'form-control', 'id' => 'last_name']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'last_name'])
    </div>
</div>

<div class="form-group">
    <label for="email">{{ __('E-mail address') }}</label>
    {{ Form::input('email', 'email', null, ['class' => 'form-control', 'id' => 'email']) }}
    @include('causeway::layouts.partials.common._error', ['name' => 'email'])
</div>

<div class="form-group">
    <label for="email">{{ __('E-mail address Confirmation') }}</label>
    {{ Form::input('email', 'email_confirmation', null, ['class' => 'form-control', 'id' => 'email_confirmation']) }}
    @include('causeway::layouts.partials.common._error', ['name' => 'email_confirmation'])
</div>

<div class="form-group">
    <label for="company">{{ __('Company') }}</label>
    {{ Form::text('company', null, ['class' => 'form-control', 'id' => 'company']) }}
    @include('causeway::layouts.partials.common._error', ['name' => 'company'])
</div>

<div class="form-group">
    <label for="phone">{{ __('Phone number') }}</label>
    {{ Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone']) }}
    @include('causeway::layouts.partials.common._error', ['name' => 'phone'])
</div>

<div class="form-row">
    <div class="form-group col-md-8">
        <label for="address">{{ __('Address') }}</label>
        {{ Form::text('address', null, ['class' => 'form-control', 'id' => 'address']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'address'])
    </div>
    <div class="form-group col-md-2">
        <label for="address_number">{{ __('Number') }}</label>
        {{ Form::text('address_number', null, ['class' => 'form-control', 'id' => 'address_number']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'address_number'])
    </div>
    <div class="form-group col-md-2">
        <label for="address_suffix">{{ __('Suffix') }}</label>
        {{ Form::text('address_suffix', null, ['class' => 'form-control', 'id' => 'address_suffix']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'address_suffix'])
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-5">
        <label for="city">{{ __('City') }}</label>
        {{ Form::text('city', null, ['class' => 'form-control', 'id' => 'city']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'city'])
    </div>
    <div class="form-group col-md-5">
        <label for="country">{{ __('Country') }}</label>
        {{ Form::select('country', countriesListArray() + ['' => '--- Make selection ---'] ?? [], null, ['class' => 'form-control', 'id' => 'country']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'country'])
    </div>
    <div class="form-group col-md-2">
        <label for="zipcode">{{ __('Zipcode') }}</label>
        {{ Form::text('zipcode', null, ['class' => 'form-control', 'id' => 'zipcode']) }}
        @include('causeway::layouts.partials.common._error', ['name' => 'zipcode'])
    </div>
</div>
