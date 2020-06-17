@extends('causeway::admin.layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header">Menu</div>

        <div class="card-body">
            @include('causeway::admin.layouts.partials._status_messages')
            <a href="{{ route('admin.menu.item.create', ['menu' => $menu->id]) }}" class="btn btn-primary btn-sm float-right">Add item</a>
            <h4>Manage {{ $menu->label }}</h4>
            <div class="clearfix"></div>

            <ul class="list-group sortableNav">
                <?php
                $itemKey = 0;
                $subItemKey = 0;
                ?>
                @foreach($menu->items()->whereNull('parent_id')->get() as $item)
                    <li class="list-group-item list-group-item-action list-group-item-sortable" id="item-{{ $item->id }}">
                        <span>{{ $item->label }}
                            <div class="pull-right">
                                <a href="{{ route('admin.menu.item.edit', ['menu' => $menu->id, 'item' => $item->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                                                                <form action="{{ route('admin.menu.item.destroy', ['menu' => $menu->id, 'item' => $item->id]) }}" class="delete-inline"
                                                                                      method="post">
                                                    {{ method_field('DELETE') }}
                                                                                    {{ csrf_field()  }}
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Remove</button>
                                                </form>
                            </div>
                        </span>
                        @if(count($item->items) > 0)
                            <ul class="list-group" style="margin-top: 20px;">
                                @foreach($item->items as $subItem)
                                    <li class="list-group-item list-group-item-action list-group-item-sortable" id="item-{{ $subItem->id }}">
                                        <span>{{ $subItem->label }}
                                            <div class="pull-right">
                                                <a href="" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('admin.menu.item.destroy', ['menu' => $menu->id, 'item' => $subItem->id]) }}" class="delete-inline" method="post">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field()  }}
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Remove</button>
                                                </form>
                                            </div>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("ul.sortableNav").nestedSortable({
                listType: 'ul',
                disableNesting: 'no-nest',
                forcePlaceholderSize: true,
                handle: 'span',
                helper: 'clone',
                items: 'li',
                maxLevels: 2,
                opacity: .6,
                placeholder: 'placeholder',
                revert: 250,
                tabSize: 25,
                tolerance: 'pointer',
                toleranceElement: '> span',
                update: function (event, ui) {
                    var data = JSON.stringify($(this).nestedSortable('toArray', {startDepthCount: 0}));
                    console.log(data);
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {data: data},
                        dataType: "json",
                        type: 'POST',
                        url: '{{ route('admin.menu.show.sort', ['menu' => $menu->id]) }}'
                    });
                }
            });
        });
    </script>
@endpush
