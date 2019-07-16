<ul class="navbar-nav mr-auto">
    @foreach($items as $item)
        {!! $item->render() !!}
    @endforeach
</ul>