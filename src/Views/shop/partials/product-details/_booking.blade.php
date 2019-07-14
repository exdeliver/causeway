<!--Grid row-->
<div class="row d-flex justify-content-center wow fadeIn">

    <!--Grid column-->
    <div class="col-md-6 text-center">

        <h4 class="my-4 h4">{{ __('Select booking date') }}</h4>

<product-calendar-booking-component :product="{{ isset($product) ? $product->toJson() : '{}' }}"
                                    :bookings="{{ isset($product) ? $product->getBookingsCollection()->map(function($date){
return [
'start' => $date['date_from'],
'end' => $date['date_to'],
];
}) : json_encode([['id' => 1, 'date_from' => null, 'date_to' => null]]) }}"></product-calendar-booking-component>

    </div>
    <!--Grid column-->
</div>