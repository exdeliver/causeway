@if(count($item->items) > 0)
    <li class="nav-item dropdown {{ request()->is($item->url .'*') ? 'active' : '' }}">
        <a href="{{ $item->url }}" class="nav-link dropdown-toggle" id="navbar{{ str_slug($item->label) }}" role="button" data-toggle="dropdown" aria-haspopup="true"
           aria-expanded="false">{{ $item->label }}</a>
        <div class="dropdown-menu" aria-labelledby="navbar{{ str_slug($item->label) }}">
            @foreach($item->items as $item)
                {!! $item->render() !!}
            @endforeach
        </div>
    </li>
@else
    @if($item->isSubmenu())
        <a class="dropdown-item" href="{{ $item->url }}">{{ $item->label }}</a>
    @else
        <li class="nav-item {{ request()->is($item->url .'*') ? 'active' : '' }}">
            <a href="{{ $item->url }}" class="nav-link">{{ $item->label }}</a>
        </li>
    @endif
@endif
