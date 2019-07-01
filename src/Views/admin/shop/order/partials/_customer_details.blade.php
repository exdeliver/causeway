<div class="container border border-dark bg-white">
    <div class="row no-gutters">
        <div class="col-6 p-2 pull-left">
            <div class="block-header">
                <h6 class="text-uppercase">Invoice address</h6>
            </div>
            <div class="block-body p-1">
                @if($invoiceContact !== null)
                    <p>
                        {{ $invoiceContact->company ?? __('Private') }}<br>
                        {{ $invoiceContact->full_name }}<br>
                        {{ $invoiceContact->address }} {{ $invoiceContact->address_number ?? '' }} {{ $invoiceContact->address_suffix ?? '' }}<br>
                        {{ $invoiceContact->city ?? '' }}<br>
                        {{ $invoiceContact->zipcode ?? '' }}<br>
                        {{ getCountryByIso($invoiceContact->country) ?? '' }}<br>
                    </p>
                @endif
            </div>
        </div>
        <div class="col-6 p-2 pull-left">
            <div class="block-header">
                <h6 class="text-uppercase">Shipping address</h6>
            </div>
            <div class="block-body">
                @if($shippingContact !== null)
                    <p>
                        {{ $shippingContact->company ?? 'Private' }}<br>
                        {{ $shippingContact->full_name }}<br>
                        {{ $shippingContact->address }} {{ $invoiceContact->address_number ?? '' }} {{ $invoiceContact->address_suffix ?? '' }}<br>
                        {{ $shippingContact->city ?? '' }}<br>
                        {{ $shippingContact->zipcode ?? '' }}<br>
                        {{ getCountryByIso($shippingContact->country) ?? '' }}<br>
                    </p>
                @else
                    <p>Same as invoice address</p>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <hr/>
        </div>
    </div>
</div>
