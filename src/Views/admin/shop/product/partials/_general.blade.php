@include('causeway::admin.common._text', [
    'title' => 'Product ID (sku)',
    'name' => 'pid',
    'description' => 'The product code for your service / product.',
    'options' => ['class' => 'form-control'],
])

@include('causeway::admin.common._text', [
    'title' => 'Title',
    'name' => 'title',
    'description' => 'The name or a short description of the product.',
    'options' => ['class' => 'form-control'],
])

@include('causeway::admin.common._textarea', [
    'title' => 'Description',
    'name' => 'description',
    'description' => 'A description about the product, try to explain as much as you can.',
    'options' => ['class' => 'form-control', 'rows' => 3, 'id' => 'summernote'],
])

<product-price-calculation-component :product="{{ isset($product) ? $product->toJson() : '{}' }}" :vat_list="{{ config('causeway.vat_percentages') }}"
                                     :errors="{{ json_encode($errors->toArray()) }}"></product-price-calculation-component>

@include('causeway::admin.common._number', [
    'title' => 'Quantity',
    'name' => 'quantity',
    'description' => 'Quantity of products in stock..',
    'options' => ['class' => 'form-control'],
])

<div class="form-group">
    <label for="categories">Categories</label>
    <select class="form-control" name="categories[]" multiple id="categories" size="7">
        @include('causeway::admin.shop.category.partials._selectMultiple', ['categories' => $categories, 'parent_id' => 0, 'model' => $product])
    </select>
    @if ($errors->has('categories'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('categories') }}</strong>
                </span>
    @endif
    <p class="alert alert-info">
        <i class="fa fa-question"></i> Make a selection of categories (hold shift for multiple) where this product should be displayed on.
    </p>
</div>

<p>
<hr/>
</p>

@include('causeway::admin.shop.product.partials.types._'.$productType)