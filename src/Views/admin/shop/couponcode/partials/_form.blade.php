@include('causeway::admin.common._text', [
    'title' => 'Name',
    'name' => 'name',
    'options' => ['class' => 'form-control'],
])

@include('causeway::admin.common._text', [
    'title' => 'Coupon code',
    'name' => 'coupon_code',
    'options' => ['class' => 'form-control'],
])

@include('causeway::admin.common._textarea', [
    'title' => 'Description',
    'name' => 'description',
    'options' => ['class' => 'form-control', 'id' => 'summernote'],
])

@include('causeway::admin.common._select', [
    'title' => 'Discount type',
    'name' => 'discount_type',
    'value' => $couponCode->discount_type ?? null,
    'data' => ['' => '--- Make selection ---'] + \Exdeliver\Causeway\Domain\Entities\Shop\CouponCode::getDiscountTypes(),
    'options' => ['class' => 'form-control'],
    'description' => 'Select the type of discount to apply on your selection.',
])

@include('causeway::admin.common._text', [
    'title' => 'Amount',
    'name' => 'discount_amount',
    'description' => 'Numeric amount of discount.',
    'options' => ['class' => 'form-control'],
])

@include('causeway::admin.common._checkbox', [
    'title' => 'Active',
    'name' => 'active',
    'options' => ['class' => 'form-control'],
])

<div class="form-group">
    <label for="categories">Categories</label>
    <select class="form-control" name="categories[]" multiple id="categories" size="7">
        @include('causeway::admin.shop.category.partials._selectMultiple', ['categories' => $categories, 'parent_id' => 0, 'model' => $couponCode ?? null])
    </select>
    @if ($errors->has('categories'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('categories') }}</strong>
                </span>
    @endif
    <p class="alert alert-info">
        <i class="fa fa-question"></i> Make a selection of categories (hold shift for multiple) to apply this discount on.
    </p>
</div>

<div class="form-group">
    <label for="categories">Products</label>
    <div id="productsSuggest"></div>
</div>

<div class="form-group">
    <hr/>
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>

@push('scripts')
    <script type="application/javascript">
        $(document).ready(function () {
            $('#summernote').summernote();

            $('#productsSuggest').magicSuggest({
                name: 'products',
                data: {!! json_encode($products->map(function ($data) {
                $result['id'] = $data->id;
                $result['name'] = $data->title;
                return $result;
                })) !!},
                maxSelection: 1000,
                value: {!! isset($couponCode) ? $couponCode->products->pluck('id')->toJson() : '{}' !!},
            });
        });
    </script>
@endpush