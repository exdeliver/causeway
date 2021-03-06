<div class="form-group">
    <label for="{{ $name }}">{{ $title }}</label>
    {!! Form::select($name, $data, $value ?? null, $options ?? ['class' => 'form-control']) !!}
    @if ($errors->has($name))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first($name) }}</strong>
                </span>
    @endif
</div>