@if(session('status'))
    <div class="alert alert-success">
        {!! Session::get('status') !!}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning">
        {!! Session::get('warning') !!}
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info">
        {!! Session::get('info') !!}
    </div>
@endif