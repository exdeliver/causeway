@foreach($categories as $category)
    <option value="{{ $category['id'] }}" {{ isset($model) && in_array($category['id'], array_column($model->categories->toArray(), 'id')) ? "selected":"" }}>{{ $category['title'] }}</option>
    @if($category['subs'])
        <optgroup label="---{{ $category['title'] }}---" class="multiple-task">
            @include('causeway::admin.shop.category.partials._selectMultiple', ['categories' => $category['subs'], 'spacing' => true])
        </optgroup>
    @endif
@endforeach