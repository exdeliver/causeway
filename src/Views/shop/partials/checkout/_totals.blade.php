<div class="mb-2 border-solid border-grey-light rounded border shadow-sm">
    <div class="bg-dark px-2 py-3 border-solid border-grey-light border-b text-white">
        {{ __('Overview') }}
    </div>
    <div class="p-3 bg-white">
        <span id="overview"></span>
        <cart-checkout-component :cart="{{ \CWCart::summary() }}" cart_details_route="{{ route('shop.cart.details') }}"></cart-checkout-component>

        <div class="form-group">
            <label for="comment">{{ __('Leave comment behind.') }}</label>
            {{ Form::textarea('comment', null, ['placeholder' => __('Leave us a message'), 'class' => 'form-control', 'rows' => 3]) }}
        </div>

        <div class="form-group">
            <label for="newsletter">{{ __('Sign-up for newsletter') }}?</label>
            {!! Form::checkbox('newsletter', 1, null, ['class' => 'form-control input-sm', 'id' => 'newsletter', 'style' => 'width: 20px; box-shadow: none;']) !!}
            @include('causeway::layouts.partials.common._error', ['name' => 'newsletter'])
        </div>

        <div class="form-group">
            <label for="terms_and_conditions">{{ __('I accept the terms and conditions') }}</label>
            {!! Form::checkbox('terms_and_conditions', 1, null, ['class' => 'form-control input-sm', 'id' => 'terms_and_conditions', 'style' => 'width: 20px; box-shadow: none;']) !!}
            @include('causeway::layouts.partials.common._error', ['name' => 'terms_and_conditions'])
        </div>

        {{ Form::submit(__('Place order now'), ['class' => 'btn btn-success btn-block']) }}
    </div>
</div>