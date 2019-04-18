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

{{ Form::textarea('content', null, ['id' => 'page-content', 'class' => 'd-none']) }}

<div class="form-group">
    <hr/>
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>

@push('scripts')
    <script type="application/javascript">
        $('#gridEditor').gridEditor({
            source_textarea: 'textarea#page-content',
            content_types: ['summernote'],
            summernote: {
                config: {
                    shortcuts: false,
                    popover: {
                        image: [
                            ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ],
                        link: [
                            ['link', ['linkDialogShow', 'unlink']]
                        ],
                        table: [
                            ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                            ['delete', ['deleteRow', 'deleteCol', 'deleteTable']]
                        ],
                        air: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline', 'clear']],
                            ['fontname', ['fontname']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['height', ['height']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'hr']],
                            ['help', ['help']]
                        ]
                    },
                }
            }
        });

        $('#page-form').on('submit', function (event) {
            var html = $('#gridEditor').gridEditor('getHtml');
            $('textarea#page-content').val(html);
        });
    </script>
@endpush