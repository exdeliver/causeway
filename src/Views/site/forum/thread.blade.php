@extends('site::layouts.site')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('site.forum.index') }}">Forum</a></li>
    <li class="breadcrumb-item"><a href="{{ route('site.forum.category', ['forumCategory' => $category->slug]) }}">{{ $category->title }}</a></li>
    <li class="breadcrumb-item active">{{ $thread->title }}</li>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Thread title: {{ $thread->title }}</div>

                    <div class="card-body">

                        <div id="page-body">
                            <main>
                                <div class="panel panel-default">
                                    <div class="responsive-images">
                                        {!! $thread->content !!}
                                    </div>
                                </div>
                            </main>
                        </div>

                    </div>

                    <div class="card-footer text-muted">
                        Posted on: {{ cmsDateTime($thread->created_at) }}
                        {{--<hr/>--}}
                        {{--Viewed by: <br/>--}}
                        {{--<ul class="list-unstyled">--}}
                        {{--<li><span class="badge badge-primary">Jason</span></li>--}}
                        {{--</ul>--}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @include('site::comments.comments', ['commentsObject' => $thread, 'type' => \Domain\Entities\Forum\Thread::class])
            </div>
        </div>
        @endsection

        @push('topscripts')
            <script type="text/javascript">
                window.Laravel.threadId = <?php echo $thread->id; ?>;
            </script>
        @endpush

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

                    $('.btn-quote-action').on('click', function () {
                        $.ajax({
                            dataType: 'json',
                            url: '{{ route('site.forum.quote') }}?comment_id=' + $(this).data('comment-id'),
                            method: 'get',
                            success: function (result) {
                                var quote = result.comment;
                                var name = result.name;
                                var date = result.date;
                                $('#summernote').summernote('pasteHTML', '<blockquote class="wp-block-quote">' +
                                    quote +
                                    '<cite>Written by: ' + name + ' on ' + date + '</cite>' +
                                    '</blockquote>');
                            }
                        });
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