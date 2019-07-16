<div class="col-md-{{ $bootstrapColWidth }}">
    <div class="mb-2 border-solid border-grey-light rounded border shadow-sm">
        <div class="p-3 bg-white">
            <p>
                <a href="{{ $product->fqn_slug }}">
                    <img src="https://via.placeholder.com/350x350.png?text=product" alt="Placeholder" title="Product name"/>
                </a>
            </p>
            <p><a href="{{ $product->fqn_slug }}"><strong>{{ $product->title }}</strong></a></p>
            <p>
            <hr class="py-0 my-0 border border-grey-lighter"/>
            </p>
            <div class="pull-left">
                <p>
                    @if($product->original_vat_price > $product->vat_price)
                        <strike>{{ money($product->original_vat_price, 'EUR') }}</strike>&nbsp;
                    @endif
                    {{ money($product->vat_price, 'EUR') }}</p>
            </div>
            <div class="pull-right">
                <add-to-cart-component show_quantity_input="0"
                                       csrf_token="{{ csrf_token() }}"
                                       add_to_cart_route="{{ route('shop.product.add_to_cart') }}"
                                       :product="{{ $product->toJson() }}">
                </add-to-cart-component>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>