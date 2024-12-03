<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-9 dropdown-submenu submenu">
        <div class="menu-title">
            @foreach($subcategories as $subcategory)
            <a class="btn-menu" href="@if($subcategory->is_click == 1){{ asset($subcategory->url) }}@else javascript:void(0) @endif" target="@if($subcategory->is_tab == 1) _blank @endif">
                <img src="{{ $subcategory->image }}" alt="">
            </a>
            @endforeach
        </div>
    </div>
</div>