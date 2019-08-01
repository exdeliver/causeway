<div class="mb-2 border-solid border-grey-light rounded border shadow-sm">
    <div class="bg-grey-lighter px-2 py-3 border-solid border-grey-light border-b">
        {{ __('Overview') }}
    </div>
    <div class="p-3 bg-white">
        <cart-totals-component :cart="{{ CWCart::summary() }}" cart_details_route="{{ route('shop.cart.details') }}"></cart-totals-component>
        {{ Form::open(['url' => route('shop.cart.order'), 'method' => 'POST', 'id' => 'shopCartForm']) }}
        <button type="submit" class="btn btn-success btn-like btn-block" for="shopCartForm">{{ __('Checkout order') }} <span class="bold">&#62;</span></button>
        @if($errors->has('product'))
            <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('product') }}</strong>
                                    </span>
        @endif
        {{ Form::close() }}
    </div>
</div>