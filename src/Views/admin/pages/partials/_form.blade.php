<div class="form-group">
    <label for="name">Language</label>
    {!! Form::select('language', \Exdeliver\Causeway\Domain\Common\Language::list(), request()->language ?? Lang::locale(), ['class' => 'form-control', 'onchange' => 'cwChangeLanguage("'.url()->current().'",this)']) !!}
    <small>Reloads page to proper chosen language. Save your changes first!</small>
</div>
<div class="form-group">
    <label for="name">Title</label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    @if ($errors->has('name'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
    @endif
</div>
<div class="form-group">
    <label for="name">Subtitle</label>
    {!! Form::text('subtitle', null, ['class' => 'form-control']) !!}
    @if ($errors->has('subtitle'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('subtitle') }}</strong>
                </span>
    @endif
</div>
<div class="form-group">
    <label for="slug">Slug</label>
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
    @if ($errors->has('slug'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('slug') }}</strong>
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

<div id="gridEditor"></div>

{{ Form::textarea('content', null, ['id' => 'page-content']) }}

<div class="form-group">
    <hr/>
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>

@push('scripts')
    <script type="application/javascript">
        Laraberg.initGutenberg('page-content', {height: '500px', laravelFilemanager: true})
    </script>
@endpush