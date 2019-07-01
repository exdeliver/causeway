<div class="mb-2 border-solid border-grey-light rounded border shadow-sm">
    <div class="bg-dark px-2 py-3 border-solid border-grey-light border-b text-white">
        {{ __('Overview') }}
    </div>
    <div class="p-3 bg-white">
        <span id="overview"></span>
        <table class="table table-striped table-hover">
            <thead>
            <tr class="first last">
                <th width="50%">
                    <span>{{ __('Product') }}</span>
                </th>
                <th class="text-center" width="30%">
                    {{ __('Quantity') }}
                </th>
                <th></th>
                <th class="text-center cart-total-head" width="10%">
                    {{ __('Gross Total') }}
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>
                        {{ $product->name }}
                    </td>
                    <td>
                        {{ $product->quantity }}
                    </td>
                    <td></td>
                    <td>
                        @if($product->type === 'discount')
                            - {{ money($product->discount_price, 'eur') }}
                        @else
                            {{ $product->total_gross_price_format ?? null }}
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr class="border-top">
                <td>

                </td>
                <td>
                    {{ __('Subtotal') }}
                </td>
                <td>

                </td>
                <td>{{ Money(\CWCart::subtotal(),'EUR') }}</td>
            </tr>
            @foreach(\CWCart::vats() as $vat)
                <tr>
                    <td>

                    </td>
                    <td>
                        <strong>{{ __('VAT') }} {{ $vat['vat']+0 }}%</strong>
                    </td>
                    <td>

                    </td>
                    <td>
                        {!! $vat['formatted_amount'] !!}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>

                </td>
                <td>
                    {{ __('Total') }}
                </td>
                <td>

                </td>
                <td>{{ Money(\CWCart::total(),'EUR') }}</td>
            </tr>
            </tbody>
        </table>

        <div class="form-group">
            <label for="comment">{{ __('Leave comment behind.') }}</label>
            {{ Form::textarea('comment', null, ['placeholder' => __('Leave us a message'), 'class' => 'form-control', 'rows' => 3]) }}
        </div>

        <div class="form-group">
            <label for="newsletter">{{ __('Sign-up for newsletter') }}?</label>
            {!! Form::checkbox('newsletter', 1, null, ['class' => 'form-control input-sm', 'id' => 'newsletter', 'style' => 'width: 20px; box-shadow: none;']) !!}
            @include('causeway::layouts.partials.common._error', ['name' => 'newsletter'])
        </div>

        <div class="form-group">
            <label for="terms_and_conditions">{{ __('I accept the terms and conditions') }}</label>
            {!! Form::checkbox('terms_and_conditions', 1, null, ['class' => 'form-control input-sm', 'id' => 'terms_and_conditions', 'style' => 'width: 20px; box-shadow: none;']) !!}
            @include('causeway::layouts.partials.common._error', ['name' => 'terms_and_conditions'])
        </div>

        {{ Form::submit(__('Place order now'), ['class' => 'btn btn-success btn-block']) }}
    </div>
</div>