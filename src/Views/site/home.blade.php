@extends('site::layouts.site')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 overflow-hidden">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        Foobar has some time. Do you know?

                        <p><router-link to="/user">Go to Foo</router-link></p>

                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
