@if($order->is_paid === true)
    <h3>{{ __('Order successfully submitted') }}!</h3>
    <p><i>{{ ('Your order has been paid successfully.') }}</i>
        <br/></p>

    <p>{{ __('We have successfully verified your payment and we will process your order as soon as possible.') }}</p>

    <p><a href="{{ route('shop.order.invoice', [
                        'orderUuid' => $order->uuid,
                    ]) }}" class="btn btn-sm btn-primary">{{ __('Display invoice') }}</a></p>
@else
    <h3>{{ __('Order cancelled') }}!</h3>
    <i>{{ __('You have cancelled the order.') }}</i>
@endif