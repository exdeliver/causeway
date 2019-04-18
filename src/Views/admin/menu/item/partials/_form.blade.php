<div class="form-group">
    <label for="name">Language</label>
    {!! Form::select('language', \Exdeliver\Causeway\Domain\Common\Language::list(), request()->language ?? Lang::locale(), ['class' => 'form-control', 'onchange' => 'cwChangeLanguage("'.url()->current().'",this)']) !!}
    <small>Reloads page to proper chosen language. Save your changes first!</small>
</div>

<div class="form-group">
    <label for="name">Parent</label>
    {!! Form::select('parent_id', $menu->items->pluck('label','id')->toArray() + ['' => '-- No parent --'], null, ['class' => 'form-control']) !!}
    @if ($errors->has('parent_id'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('parent_id') }}</strong>
                </span>
    @endif
</div>

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
    <label for="slug">URL</label>
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
    @if ($errors->has('url'))
        <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $errors->first('url') }}</strong>
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