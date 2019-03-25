@extends('layouts.site')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Play</div>

                    <div class="card-body">

                        @include('sound.partials._player')

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection