<tr>
    <td>
        <img src="https://via.placeholder.com/100" alt="Placeholder" title="Product name"/>
        <p>
            <a href="{{ $product->id }}" title="{{ $product->name }}"><strong>{{ $product->name }}</strong></a>
        </p>
        <div class="clearfix"></div>
    </td>
    <td class="text-center">
        <div class="input-group">
            <div class="input-group-append">
                <a id="productSub" href="#" class="btn btn-primary">
                    <i class="fa fa-minus-circle"></i>
                </a>
            </div>
            {{ Form::number('quantity', 0, ['class' => 'form-control text-center', 'for' => 'shopCartForm']) }}
            <div class="input-group-append">
                <a id="productPlus" href="#" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i>
                </a>
            </div>
        </div>
    </td>
    <td>

    </td>
    <td class="text-center">
        <span id="productTotalPrice">{{ money(20, 'EUR') }}</span>
    </td>
    <td class="text-center">
        <a href="#" title="{{ __('Remove product') }}"><i class="fa fa-remove"></i></a>
    </td>
</tr>