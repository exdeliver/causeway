@extends('layouts.site')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('site.forum.index') }}">Forum</a></li>
    <li class="breadcrumb-item"><a href="{{ route('site.forum.category', ['forumCategory' => $category->slug]) }}">{{ $category->title }}</a></li>
    <li class="breadcrumb-item active">New thread</li>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New Thread</div>

                    <div class="card-body">

                        <div id="page-body">
                            <main>
                                <div class="panel panel-default">
                                    <p>
                                        <small>Category: {{ $category->title }}</small>
                                    </p>
                                    {{ Form::open(['url' => route('site.forum.thread.store', ['forumCategory' => $category->slug]), 'files' => true, 'method' => 'post']) }}
                                    @include('forum.partials._threadForm')
                                    {{ Form::close() }}
                                </div>
                            </main>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection