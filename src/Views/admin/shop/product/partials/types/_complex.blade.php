<h4><strong>{{ ucfirst($productType) }}</strong> Settings</h4>

<product-variant-component :product="{{ isset($product) ? $product->toJson() : '{}' }}" :variants="{{ isset($product) ? $product->variants->toJson() : json_encode(['id' => 1, 'name' => null, 'values' => [['id' => 1, 'name' => null]]]) }}"></product-variant-component>