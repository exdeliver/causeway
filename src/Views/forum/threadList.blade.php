@extends('layouts.site')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('site.forum.index') }}">Forum</a></li>
    <li class="breadcrumb-item active">{{ $category->title }}</li>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Forum: {{ $category->title }}</div>

                    <div class="card-body">

                        <div id="page-body">

                            <div class="clearfix">
                                <div class="pull-left">
                                    <p>
                                        <a href="{{ route('site.forum.thread.new', ['forumCategory' => $category->slug]) }}" role="button" class="btn btn-default btn-outline-dark btn-load"
                                           data-loading-text="Loading&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>" data-original-title="" title=""><i class="fa fa-plus"></i>&nbsp;New
                                            Topic</a>
                                    </p>
                                </div>

                                <div class="pull-right">
                                    {{ $threads->render() }}
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <table class="footable table table-striped table-bordered table-white table-hover default footable-loaded">
                                    <thead>
                                    <tr>
                                        <th data-class="expand" class="footable-visible footable-first-column"><i class="fa fa-bullhorn"></i> Topic</th>
                                        <th class="large80 footable-visible" data-hide="phone"><i class="fa fa-bar-chart-o"></i> Statistics</th>
                                        <th class="large20 footable-visible footable-last-column" data-hide="phone"><i class="fa fa-comments-o"></i> Last post</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($threads as $thread)
                                        <tr>
                                            <td class="expand footable-visible footable-first-column">
                                                <span class="footable-toggle"></span>
                                                <span class="icon-wrapper">
                                                    <i class="row-icon-font icon-moon-default2 icon-moon-podcast2 forum-read" title="No unread posts"></i>
                                                </span>
                                                <i class="row-icon-font-mini" title="No unread posts"></i>
                                                <div class="desc-wrapper">
                                                    <a href="{{ route('site.forum.thread', ['forumCategory' => $category->slug, 'forumThread' => $thread->slug]) }}" class="topictitle"
                                                       data-original-title="" title="">{!! $thread->title !!}</a>
                                                    <br>
                                                    by&nbsp;<a
                                                            href="{{ route('site.forum.thread', ['forumCategory' => $category->slug, 'forumThread' => $thread->slug]) }}" style="color: #AA0000;"
                                                            class="username-coloured"
                                                            data-original-title="" title="">{{ $thread->user->name }}</a>
                                                    <small>&nbsp;-&nbsp;{{ cmsDateTime($thread->created_at) }}</small>

                                                </div>
                                            </td>
                                            <td class="stats-col footable-visible">
                                             <span class="stats-wrapper">
                                             {{ count($thread->comments) }}&nbsp;Replies&nbsp;<br>
                                                 {{--&nbsp;13315&nbsp;Views--}}
                                             </span>
                                            </td>
                                            <td class="footable-visible footable-last-column">
			                                    <span class="last-wrapper text-overflow">
						                        {{ isset($thread->comments()->first()->user->name) ? 'by ' . $thread->comments()->first()->user->name : null }}<br/>
                                                <small>{{ cmsDateTime($thread->comments()->first()->created_at ?? null) }}</small>
			                                    </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="clearfix">
                                    <div class="pull-right">
                                        {{ $threads->render() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection