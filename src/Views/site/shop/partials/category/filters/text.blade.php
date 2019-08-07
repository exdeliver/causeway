<div class="form-group">
    <label>{{ $name }}</label>
    {{ Form::text($name, $value ?? null, ['placeholder' => 'Foobar', 'class' => 'form-control']) }}
</div>
