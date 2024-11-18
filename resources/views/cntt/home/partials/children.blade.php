<li>
    @if (isset($category->children) && count($category->children) > 0)
        <a href="{{ $category->slug }}">{{ $category->name }}</a>
        <a class="caret" href="{{ $category->slug }}">+</a>
        <ul class="nested">
            @foreach ($category->children as $child)
                @include('cntt.home.partials.children', ['category' => $child])
            @endforeach
        </ul>
    @else
        <a href="{{ $category->slug }}">{{ $category->name }}</a>
    @endif
</li>