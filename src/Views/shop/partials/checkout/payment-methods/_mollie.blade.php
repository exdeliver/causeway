@include('causeway::layouts.partials.common._error', ['name' => 'payment'])
@foreach ($paymentMethods as $method)
    <div style="line-height:40px; vertical-align:top" class="border-b-2 pt-2">
        <div class="form-check">
            {{ Form::radio('payment', $method->id, false, ['class' => 'form-check-input', 'id' => 'payment'.$method->id, 'style' => 'width:20px;']) }}
            <label for="payment{{$method->id}}" class="form-check-label">
                &nbsp;<img src="{{ htmlspecialchars($method->image->size1x) }}" srcset="{{ htmlspecialchars($method->image->size2x) }} 2x" class="pull-left">
                {{ htmlspecialchars($method->description)  }}
            </label>
        </div>
    </div>
@endforeach