<div class="form-group">
    <label>{{ $title }}</label>
    {{ Form::select('filters['.$name.']', $data, $value ?? null, ['class' => 'form-control']) }}
</div>
