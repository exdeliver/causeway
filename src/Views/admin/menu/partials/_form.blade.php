<div class="form-group">
    <label for="name">Label</label>
    {!! Form::text('label', null, ['class' => 'form-control']) !!}
    @if ($errors->has('label'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('label') }}</strong>
                </span>
    @endif
</div>

<div class="form-group">
    <hr/>
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>

@push('scripts')

@endpush