<h4><strong>{{ ucfirst($productType) }}</strong> Settings</h4>

<div class="card card-body">
    <p class="text-center">
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseVariantsGenerator" aria-expanded="false" aria-controls="collapseVariantsGenerator">
            Generate variants
        </button>
    </p>
    <div class="collapse" id="collapseVariantsGenerator">
        @if(request()->old('variant'))
            <product-variant-component :formErrors="{{ $errors->has('variant') ? $errors->get('variant') : '{}' }}" :product="{{ isset($product) ? $product->toJson() : '{}' }}"
                                       :variants="{{ request()->old('variant') ? json_encode(request()->old('variant')) : json_encode([['id' => 1, 'name' => null, 'sequence' => 0, 'values' => [['id' => 1, 'name' => null, 'sequence' => 0]]]]) }}"></product-variant-component>
        @else
            <product-variant-component :formErrors="{{ $errors->has('variant') ? $errors->only('variant') : '{}' }}" :product="{{ isset($product) ? $product->toJson() : '{}' }}"
                                       :variants="{{ isset($product) ? $product->getVariantsCollection() : json_encode([['id' => 1, 'name' => null, 'sequence' => 0, 'values' => [['id' => 1, 'name' => null, 'sequence' => 0]]]]) }}"></product-variant-component>
        @endif

    </div>

    @if(isset($product))
        <p class="alert alert-info">
            Manage your generated product variants below. Advanced features such as above may be accessed by going to the product details.
        </p>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>
                    Name
                </th>
                <th width="20%">
                    Gross price
                </th>
                <th width="20%">
                    Special price
                </th>
                <th width="20%">
                    SKU
                </th>
                <th>
                    Manage
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($product->getVariants() as $variant)
                <tr>
                    <td>
                        {{ $variant->title }}
                    </td>
                    <td>
                        {{ Form::text('variantProduct['.$variant->id.'][gross_price]', $variant->gross_price / 100, ['class' => 'form-control']) }}
                    </td>
                    <td>
                        {{ Form::text('variantProduct['.$variant->id.'][special_price]', $variant->special_price / 100, ['class' => 'form-control']) }}
                    </td>
                    <td>
                        {{ Form::text('variantProduct['.$variant->id.'][pid]', $variant->pid, ['class' => 'form-control']) }}
                    </td>
                    <td>
                        <a href="{{ route('admin.shop.product.update', ['product' => $variant->id]) }}" class="btn btn-sm btn-warning pull-left mr-2">Edit</a>
                        <a href="{{ route('admin.shop.product.getDelete', ['product' => $variant->id]) }}" class="btn btn-sm btn-danger pull-left" onclick="return confirm(;\'Are you sure?\')">Remove</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
