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
    <label for="name">Message</label>
    {!! Form::textarea('content', null, ['class' => 'form-control', 'id' => 'summernote']) !!}
    @if ($errors->has('content'))
        <span class="invalid-feedback  d-block" role="alert">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
    @endif
</div>

<div class="form-group">
    <hr/>
    {!! Form::submit('Save Thread', ['class' => 'btn btn-primary']) !!}
</div>


@push('scripts')
    <script type="application/javascript">
        $(document).ready(function () {
            $('#summernote').summernote({
                callbacks: {
                    onImageUpload: function (files) {
                        url = '{{ route('site.upload') }}'; //path is defined as data attribute for  textarea
                        sendFile(files[0], url, $(this));

                    }
                }
            });

            function sendFile(file, url, editor) {
                var data = new FormData();
                data.append("file", file);
                var request = new XMLHttpRequest();
                var csrfToken = "{{ csrf_token() }}";
                request.open('POST', url, true);
                request.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                request.onload = function () {
                    if (request.status >= 200 && request.status < 400) {
                        // Success!
                        var resp = request.responseText;
                        editor.summernote('insertImage', resp);
                        console.log(resp);
                    } else {
                        // We reached our target server, but it returned an error
                        var resp = request.responseText;
                        console.log(resp);
                    }
                };
                request.onerror = function (jqXHR, textStatus, errorThrown) {
                    // There was a connection error of some sort
                    console.log(jqXHR);
                };
                request.send(data);
            }
        });
    </script>
@endpush