<li class="nav-item sub-pt-30">
    @if($child->children->isNotEmpty())
    <a class="link-sub-mb" id="nav-link-mb-{{ $child->id }}" href="@if($child->is_click == 1){{ asset($child->url) }}@else javascript:void(0) @endif" target="@if($child->is_tab == 1) _blank @endif" data-id="{{ $child->id }}">
        {{ $child->name }}
    </a>
    <hr>
    @foreach ($child->children as $grandchild)
    <li class="nav-item sub-pt-10">
        <a class="link-sub-mb" id="nav-link-mb-{{ $grandchild->id }}" href="@if($grandchild->is_click == 1){{ asset($grandchild->url) }}@else javascript:void(0) @endif" target="@if($grandchild->is_tab == 1) _blank @endif" data-id="{{ $grandchild->id }}" data-id="{{ $grandchild->id }}">
            {{ $grandchild->name }}
        </a>
    </li>
    @endforeach
    @else
    <a class="link-sub-mb" id="nav-link-mb-{{ $child->id }}" href="@if($child->is_click == 1){{ asset($child->url) }}@else javascript:void(0) @endif" target="@if($child->is_tab == 1) _blank @endif" data-id="{{ $child->id }}">
        {{ $child->name }}
    </a>
    <hr>
    @endif
</li>