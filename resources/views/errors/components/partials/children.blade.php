<div class="row">
@foreach($subcategories as $subcategory)
<div class="col-2 dropdown-submenu">
    @if ($category->stt_menu == 1)
    <div class="dropdown-sub menu-title-{{ $category->stt_menu }}">
        <ul class="title-sub">
            <li class="list-group-item menu-lg-item">{{ $subcategory->name }}</li>
            <div class="list-sub">
                <div class="container">
                    @foreach($subcategory->children as $child)
                    <div class="menu-title-child">
                        <ul class="list-group">
                            <li class="list-group-item menu-lg-child">{{ $child->name }}</li>
                            <hr>
                            @foreach($child->children as $child1)
                            <li class="list-group-item menu-lg-child1">
                                <a href="{{ asset($child->url) }}">{{ $child1->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
        </ul>
    </div>
    @elseif ($category->stt_menu == 2)
    <div class="menu-title-{{ $category->stt_menu }}">
        <ul class="list-group">
            <li class="list-group-item menu-item">{{ $subcategory->name }}</li>
            <hr>
            @foreach($subcategory->children as $child)
            <li class="list-group-item menu-item-child">
                <a href="{{ asset($child->url) }}">{{ $child->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    @elseif ($category->stt_menu == 3)
    <div class="menu-title-{{ $category->stt_menu }}">
        {{ $subcategory->name }}
        <hr>
    </div>
    <div class="row w-menu-{{ $category->stt_menu }}">
        @foreach($subcategory->children as $child)
        <div class="col-3 text-menu-{{ $category->stt_menu }}">
            <a href="{{ asset($child->url) }}">{{ $child->name }}</a>
        </div>
        @endforeach
    </div>
    @elseif ($category->stt_menu == 4)
    <div class="menu-title-4">
        <ul class="list-group">
            <li class="list-group-item menu-item-{{ $category->stt_menu }}">{{ $subcategory->name }}</li>
        </ul>
    </div>
    @endif
</div>
@endforeach
</div>