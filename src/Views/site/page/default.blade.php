@extends('site::layouts.site')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $page->name }}</div>

                    <div class="card-body">
                        {!! $page->translate()->transform() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
