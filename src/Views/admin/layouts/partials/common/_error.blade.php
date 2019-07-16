@if($errors->has($name))
    <span class="invalid-feedback d-block error-border-top" role="alert">
        <strong>{{ $errors->first($name) }}</strong>
    </span>
@endif