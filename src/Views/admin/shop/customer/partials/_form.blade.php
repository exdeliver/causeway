@include('causeway::admin.common._text', [
    'title' => 'Company name',
    'name' => 'company',
    'options' => ['class' => 'form-control'],
])

<hr />

@include('causeway::admin.common._text', [
    'title' => 'First name',
    'name' => 'first_name',
    'options' => ['class' => 'form-control'],
])

@include('causeway::admin.common._text', [
    'title' => 'Last name',
    'name' => 'last_name',
    'options' => ['class' => 'form-control'],
])

<hr />

@include('causeway::admin.common._text', [
    'title' => 'E-mail address',
    'name' => 'email',
    'options' => ['class' => 'form-control'],
])

@include('causeway::admin.common._text', [
    'title' => 'E-mail address (confirmation)',
    'name' => 'email_confirmation',
    'value' => $customer->primaryContact()->email,
    'options' => ['class' => 'form-control'],
])

@include('causeway::admin.common._text', [
    'title' => 'Phone',
    'name' => 'phone',
    'options' => ['class' => 'form-control'],
])


<div class="form-row">
    <div class="form-group col-md-8">
        <label for="address">{{ __('Address') }}</label>
        {{ Form::text('address', null, ['class' => 'form-control', 'id' => 'address']) }}
        @include('site::layouts.partials.common._error', ['name' => 'address'])
    </div>
    <div class="form-group col-md-2">
        <label for="address_number">{{ __('Number') }}</label>
        {{ Form::text('address_number', null, ['class' => 'form-control', 'id' => 'address_number']) }}
        @include('site::layouts.partials.common._error', ['name' => 'address_number'])
    </div>
    <div class="form-group col-md-2">
        <label for="address_suffix">{{ __('Suffix') }}</label>
        {{ Form::text('address_suffix', null, ['class' => 'form-control', 'id' => 'address_suffix']) }}
        @include('site::layouts.partials.common._error', ['name' => 'address_suffix'])
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-5">
        <label for="city">{{ __('City') }}</label>
        {{ Form::text('city', null, ['class' => 'form-control', 'id' => 'city']) }}
        @include('site::layouts.partials.common._error', ['name' => 'city'])
    </div>
    <div class="form-group col-md-5">
        <label for="country">{{ __('Country') }}</label>
        {{ Form::select('country', countriesListArray() + ['' => '--- Make selection ---'] ?? [], null, ['class' => 'form-control', 'id' => 'country']) }}
        @include('site::layouts.partials.common._error', ['name' => 'country'])
    </div>
    <div class="form-group col-md-2">
        <label for="zipcode">{{ __('Zipcode') }}</label>
        {{ Form::text('zipcode', null, ['class' => 'form-control', 'id' => 'zipcode']) }}
        @include('site::layouts.partials.common._error', ['name' => 'zipcode'])
    </div>
</div>

<div class="form-group">
    <hr/>
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>

@push('scripts')
    <script type="application/javascript">
        $(document).ready(function () {
            $('#summernote').summernote();
        });
@endpush