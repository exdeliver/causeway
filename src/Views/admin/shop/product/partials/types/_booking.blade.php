<h4><strong>{{ ucfirst($productType) }}</strong> Settings</h4>

@if(request()->old('booking'))
    <product-booking-component :product="{{ isset($product) ? $product->toJson() : '{}' }}"
                               :bookings="{{ request()->old('booking') ? json_encode(request()->old('booking')) : json_encode([['id' => 1, 'date_from' => null, 'date_to' => null]])  }}"></product-booking-component>
@else
    <product-booking-component :product="{{ isset($product) ? $product->toJson() : '{}' }}"
                               :bookings="{{ isset($product) ? $product->getBookingsCollection() : json_encode([['id' => 1, 'date_from' => null, 'date_to' => null]]) }}"></product-booking-component>
@endif