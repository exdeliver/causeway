<div class="form-group">
    <label>{{ $title }}</label>
    @foreach($data as $availableValue)
        <label>{{ $availableValue->attribute_value }}</label>
        {{ Form::checkbox('filters['.$name.']', 1, $value ?? null, ['class' => 'form-control']) }}
    @endforeach
</div>
