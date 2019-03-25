<div class="form-group">
    <label for="name">Name</label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    @if ($errors->has('name'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
    @endif
</div>

<div class="form-group">
    <label for="artist">Artist</label>
    {!! Form::text('artist', null, ['class' => 'form-control']) !!}
    @if ($errors->has('artist'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('artist') }}</strong>
                </span>
    @endif
</div>

<div class="form-group">
    <label for="artist">Description</label>
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    @if ($errors->has('description'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
    @endif
</div>

<div class="form-group">
    <label for="file">Music File</label>
    {!! Form::file('filename', ['class' => 'form-control']) !!}
    @if ($errors->has('filename'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('filename') }}</strong>
                </span>
    @endif
</div>

<div class="form-group">
    <label for="access_level">Access level</label>
    {!! Form::select('access_level', accessLevelList(), null, ['class' => 'form-control']) !!}
    @if ($errors->has('access_level'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('access_level') }}</strong>
                </span>
    @endif
</div>

<div class="form-group">
    <hr/>
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>

@push('scripts')

@endpush