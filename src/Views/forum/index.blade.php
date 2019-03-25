@extends('layouts.site')

@section('breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route('site.forum.index') }}">Forum</a></li>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Forum</div>

                    <div class="card-body">

                        <div id="page-body">
                            <main>
                                <div class="panel panel-default">
                                    @foreach($forumCategories as $category)
                                        <forum-category-component :category="{{ $category->toJson() }}"></forum-category-component>
                                    @endforeach
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection