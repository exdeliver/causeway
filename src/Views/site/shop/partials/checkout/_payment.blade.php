<div class="mb-2 border-solid border-grey-light rounded border shadow-sm">
    <div class="bg-dark px-2 py-3 border-solid border-grey-light border-b text-white">
        {{ __('Payment method') }}
    </div>
    <div class="p-3 bg-white">
        <p class="alert alert-info">
            {{ __('Please select your payment method') }}
        </p>
        <span id="payment-provider">
            @include('site::shop.partials.checkout.payment-methods._mollie')
        </span>
    </div>
</div>