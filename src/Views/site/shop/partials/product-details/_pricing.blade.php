<p class="lead">
<p>
    @if($product->original_vat_price > $product->vat_price)
        <span class="mr-1">
        <del>{{ money($product->original_vat_price,'EUR') }}</del>
    </span>
    @endif
    <span>{{ money($product->vat_price,'EUR') }}</span>
</p>