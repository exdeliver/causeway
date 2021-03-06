<table class="table">
    <thead>
    <th>
        {{ __('Product') }}
    </th>
    <th>
        {{ __('Quantity') }}
    </th>
    <th>
        {{ __(' Gross Total') }}
    </th>
    </thead>
    @foreach($order->items()->where('type','item')->get() as $item)
        <tr>
            <td>
                {{ $item->name }}
            </td>
            <td>
                {{ $item->quantity }}
            </td>
            <td>
                {!! Akaunting\Money\Money::EUR($item->quantity * $item->gross_price)->format() !!}
            </td>
        </tr>
    @endforeach
    <tr>
        <td>

        </td>
        <td>
            <strong>{{ __('Subtotal') }}</strong>
        </td>
        <td>
            {!! \Akaunting\Money\Money::EUR($subtotal) !!}
        </td>
    </tr>
    <tr>
    @foreach($vats as $vat)
        <tr>
            <td>

            </td>
            <td>
                <strong>{{ __('VAT') }} {{ $vat['vat']+0 }}%</strong>
            </td>
            <td>
                {!! $vat['formatted_amount'] !!}
            </td>
        </tr>
    @endforeach
    <tr>
        <td>

        </td>
        <td>
            <strong>{{ __('Total') }}</strong>
        </td>
        <td>
            {!! \Akaunting\Money\Money::EUR($total) !!}
        </td>
    </tr>
</table>