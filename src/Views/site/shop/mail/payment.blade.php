@component('mail::message')
    # {{ __('Thank you for your order.') }}

    {{ __('Dear '.$customer->first_name.',') }}

    {{ __('Your payment for this order has successfully been received and we will process your order as soon as possible.') }}
    {{ __('As soon as we have processed your order, you will receive an notification.') }}

@component('mail::button', ['url' => route('shop.order.invoice', ['invoice' => $order->uuid])])
    {{ __('Download invoice') }}
@endcomponent

@component('mail::panel')
    {{ __('Order reference: #'. $order->id) }}
---

| Service | Quantity | Gross total |
|:-------:|:--------:|:-----------:|
@foreach($order->items()->where('type','item')->get() as $product)
| {{ $product->name }}       | {{ $product->quantity }}        | {{ money($product->quantity * $product->gross_price,'eur') }}           |
@endforeach

@endcomponent

    {{ __('With kind regards') }},
    {{ config('app.name') }}
@endcomponent
