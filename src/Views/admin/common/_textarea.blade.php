<div class="form-group">
    <label for="{{ $name }}">{{ $title }}</label>
    {!! Form::textarea($name, $value ?? null, $options ?? ['class' => 'form-control']) !!}
    @if ($errors->has($name))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first($name) }}</strong>
                </span>
    @endif

    @if(isset($description))
        <p class="alert alert-info">
            <i class="fa fa-question"></i> {!! $description !!}
        </p>
    @endif
</div>