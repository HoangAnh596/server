<li>
    @if (isset($category->children) && count($category->children) > 0)
        <a href="{{ asset($category->slug) }}">{{ $category->name }}</a>
        <a class="caret" href="{{ asset($category->slug) }}">+</a>
        <ul class="nested">
            @foreach ($category->children as $child)
                @include('cntt.home.partials.children', ['category' => $child])
            @endforeach
        </ul>
    @else
        <a href="{{ asset($category->slug) }}">{{ $category->name }}</a>
    @endif
</li>