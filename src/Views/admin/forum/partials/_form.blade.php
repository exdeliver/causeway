<div class="form-group">
    <label for="parent_id">Parent</label>
    {{ Form::select('parent_id', $forumCategories + ['' => '--- None ---'], null, ['class' => 'form-control']) }}
    @if ($errors->has('parent_id'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('parent_id') }}</strong>
                </span>
    @endif
</div>

<div class="form-group">
    <label for="name">Title</label>
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
    @if ($errors->has('title'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
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