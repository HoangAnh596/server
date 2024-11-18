<div class="row">
<?php $countMenu = 0?>
@foreach($subcategories as $subcategory)
<?php $countMenu++; $countMenu?>
<div class="col-2 dropdown-submenu submenu-{{ $count }}">
    @if ($count == 1)
    <div class="dropdown-sub menu-title-{{ $count }} @if($countMenu == 1) active @endif menu-title-{{ $count }}" data-default="true">
        <ul class="title-sub">
            <li class="list-group-item menu-lg-item">
                <a class="btn-menu" href="@if($subcategory->is_click == 1){{ asset($subcategory->url) }}@else javascript:void(0) @endif" target="@if($subcategory->is_tab == 1) _blank @endif">{{ $subcategory->name }}</a>
            </li>
            <div class="list-sub">
                <div class="container">
                    @foreach($subcategory->children as $child)
                    <div class="menu-title-child">
                        <ul class="list-group">
                            <li class="list-group-item menu-lg-child"><a class="btn-menu" href="@if($subcategory->is_click == 1){{ asset($subcategory->url) }}@else javascript:void(0) @endif" target="@if($subcategory->is_tab == 1) _blank @endif">{{ $child->name }}</a></li>
                            <hr>
                            @foreach($child->children as $child1)
                            <li class="list-group-item menu-lg-child1">
                                <a href="@if($child1->is_click == 1){{ asset($child1->url) }}@else javascript:void(0) @endif" target="@if($child1->is_tab == 1) _blank @endif">{{ $child1->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </ul>
    </div>
    @elseif ($count == 2)
    <div class="menu-title-{{ $count }}">
        <ul class="list-group">
            <li class="list-group-item menu-item menu-item-{{ $count }}">
                <a class="btn-menu" href="@if($subcategory->is_click == 1){{ asset($subcategory->url) }}@else javascript:void(0) @endif" target="@if($subcategory->is_tab == 1) _blank @endif">
                    {{ $subcategory->name }}
                </a>
            </li>
            <hr>
            @foreach($subcategory->children as $child)
            <li class="list-group-item menu-item-child">
                <a href="@if($child->is_click == 1){{ asset($child->url) }}@else javascript:void(0) @endif" target="@if($child->is_tab == 1) _blank @endif">{{ $child->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    @elseif ($count == 3)
    <div class="menu-title-{{ $count }}">
        <a class="btn-menu" href="@if($subcategory->is_click == 1){{ asset($subcategory->url) }}@else javascript:void(0) @endif" target="@if($subcategory->is_tab == 1) _blank @endif">{{ $subcategory->name }}</a>
        <hr>
    </div>
    <div class="row w-menu-{{ $count }}">
        @foreach($subcategory->children as $child)
        <div class="col-3 text-menu-{{ $count }}">
            <a href="@if($child->is_click == 1){{ asset($child->url) }}@else javascript:void(0) @endif" target="@if($child->is_tab == 1) _blank @endif">{{ $child->name }}</a>
        </div>
        @endforeach
    </div>
    @elseif ($count == 4)
    <div class="menu-title-4">
        <ul class="list-group">
            <li class="list-group-item menu-item-{{ $count }}"><a href="@if($subcategory->is_click == 1){{ asset($subcategory->url) }}@else javascript:void(0) @endif" target="@if($subcategory->is_tab == 1) _blank @endif">{{ $subcategory->name }}</a></li>
        </ul>
    </div>
    @endif
</div>
@endforeach
</div>
