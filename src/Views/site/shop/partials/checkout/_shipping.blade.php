<div class="mb-2 border-solid border-grey-light rounded border shadow-sm">
    <div class="bg-dark px-2 py-3 border-solid border-grey-light border-b text-white">
        {{ __('Shipping details') }}
    </div>
    <div class="p-3 bg-white">
        <p class="alert alert-info">
            Please select a shipping method
        </p>
        @include('site::layouts.partials.common._error', ['name' => 'shipping'])

        @foreach ($shippingMethods as $method)
            <checkout-shippingmethod-component csrf_token="{{ csrf_token() }}"
                                               add_to_cart_route="{{ route('shop.product.add_shipping_method') }}"
                                               :shipping="{{ $method->toJson() }}"></checkout-shippingmethod-component>
        @endforeach
    </div>
</div>