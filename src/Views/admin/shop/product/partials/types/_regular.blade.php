<h4><strong>{{ ucfirst($productType) }}</strong> Settings</h4>

@include('causeway::admin.common._number', [
    'title' => 'Product weight (KG)',
    'name' => 'weight',
    'description' => 'The weight of the product in kilograms. (May help to calculate shipping costs)',
    'options' => ['class' => 'form-control'],
])
