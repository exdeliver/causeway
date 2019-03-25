@if(count($item->items) > 0)
    <li class="nav-item dropdown">
        <a href="{{ $item->url }}" class="nav-link dropdown-toggle" id="navbar{{ str_slug($item->label) }}" role="button" data-toggle="dropdown" aria-haspopup="true"
           aria-expanded="false">{{ $item->label }}</a>
        <div class="dropdown-menu" aria-labelledby="navbar{{ str_slug($item->label) }}">
            @foreach($item->items()->orderBy('sequence', 'asc')->get() as $item)
                <a class="dropdown-item" href="{{ $item->url }}">{{ $item->label }}</a>
            @endforeach
        </div>
    </li>
@else
    <li class="nav-item">
        <a href="{{ $item->url }}" class="nav-link">{{ $item->label }}</a>
    </li>
@endif
