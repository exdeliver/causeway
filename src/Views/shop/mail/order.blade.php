@component('mail::message')
    # {{ __('Thank you for your order.') }}

    {{ __('Dear '.$customer->first_name.',') }}

    {{ __('Your order has successfully been received and we will process your order as soon as we have received your payment.') }}

@component('mail::button', ['url' => route('shop.order.invoice', ['id' => $order->uuid])])
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