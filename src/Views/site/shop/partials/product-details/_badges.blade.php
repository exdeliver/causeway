<div class="mb-3">
    <p><strong>{{ __('Categories') }}</strong><br/>
    <hr class="py-0 my-0 border border-grey-lighter"/>
    </p>
    @foreach($product->categories as $category)
        <a href="{{ route('shop.category', ['slug' => $category->slug]) }}">
            <span class="badge badge-info mr-1">{{ $category->title }}</span>
        </a>
    @endforeach
    {{--    <a href="">--}}
    {{--        <span class="badge blue mr-1">New</span>--}}
    {{--    </a>--}}
    {{--    <a href="">--}}
    {{--        <span class="badge red mr-1">Bestseller</span>--}}
    {{--    </a>--}}
</div>