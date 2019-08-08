<div class="form-group">
    <label>{{ $title }}</label>
    {{ Form::text('filters['.$name.']', $value ?? null, ['class' => 'form-control']) }}
</div>
