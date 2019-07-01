<div class="mb-2 border-solid border-grey-light bg-light rounded border shadow-sm">
    <div class="bg-grey-lighter px-2 py-3 border-solid border-grey-light border-b">
        {{ __('Add coupon code or giftcard?') }}
    </div>
    <div class="p-3 bg-white">
        {{ Form::open(['url' => route('shop.couponcode.store'), 'id' => 'couponCodeForm']) }}
        <div class="input-group">
            {{ Form::text('coupon_code', null, ['class' => 'form-control', 'placeholder' => 'Your code...', 'id' => 'couponCodeForm']) }}
            <div class="input-group-append">
                <button id="basic-addon2" class="btn btn-primary" type="submit" for="couponCodeForm">{{ __('Add Coupon Code') }}</button>
            </div>
            @if ($errors->has('coupon_code'))
                <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('coupon_code') }}</strong>
                </span>
            @endif
        </div>
        {{ Form::close() }}
    </div>
</div>