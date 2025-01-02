@php
$agent = new Jenssegers\Agent\Agent();
@endphp
<!-- Header -->

<div class="container">
    <div class="row py-md-3 py-xs-3">
        <div class="col-lg-3 col-md-3 col-sm-3 d-none d-sm-block">
            <a href="{{ asset('/') }}">
                <img class="logo" width="275" height="58" title="Logo Công Ty TNHH Việt Thái Dương" alt="Logo Công Ty TNHH Việt Thái Dương" src="https://cnttshop.vn/uploads/images/logo/logo-cnttshopvn.png" data-src="https://cnttshop.vn/uploads/images/logo/logo-cnttshopvn.png" data-srcset="https://cnttshop.vn/uploads/images/logo/logo-cnttshopvn.png" srcset="https://cnttshop.vn/uploads/images/logo/logo-cnttshopvn.png">
            </a>
        </div>

        <div class="col-lg-6 col-md-5 col-sm-4 width-lg-search">
            <div class="form-serach">
                <form method="GET" action="{{ route('home.search') }}" accept-charset="utf-8" id="menupanelsearch" class="my-2 mt-lg-2 d-flex">
                    <select name="cate" aria-labelledby="searchSgg">
                        <option value="prod">Tất cả sản phẩm</option>
                        <option value="news">Tất cả bài viết</option>
                        @if(isset($searchCate))
                        @foreach($searchCate as $category)
                        @php
                        $optionValue = $category->source . '_' . $category->id;
                        $isSelected = \Request::get('cate') == $optionValue ? "selected" : "";
                        @endphp
                        <option value="{{ $optionValue }}" {{ $isSelected }}>
                            @if($category->source == 'prod')
                            {{ $category->name }}--Sản phẩm
                            @elseif($category->source == 'news')
                            {{ $category->name }}--Bài viết
                            @endif
                        </option>
                        @endforeach
                        @endif
                    </select>
                    <input type="text" class="form-control" name="keyword" id="searchSgg" placeholder="Bạn cần tìm gì...">
                    <button class="search-submit"><i class="fa fa-search"></i></button>
                    <div class="autoSuggestionsList_l" id="autoSuggestionsList"></div>
                </form>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-5 ddd-none d-lg-block width-lg">
            <span class="phone-header phone-header-fixed d-flex justify-content-center">
                <i class="fa-solid fa-phone"></i> Server:
                <a class="d-none d-sm-inline" rel="nofollow" href="tel:0866176188">0866 176 188</a>
            </span>
            <span class="phone-header phone-header-fixed d-flex justify-content-center">
                <i class="fa-solid fa-phone"></i> Thiết bị mạng:
                <a class="d-none d-sm-inline" rel="nofollow" href="tel:0862158859">0862 158 859</a>
            </span>
            <span class="phone-header d-flex justify-content-center"><i class="fa-solid fa-phone"></i>Mua hàng: <a rel="nofollow" href="tel:0963506565"> 0963 506 565</a></span>
        </div>
    </div>
</div>
@if($agent->isMobile())
<nav class="navbar navbar-expand-lg bg-body-tertiary navbar-mobile">
    <!-- css mobilde if fixed add class nav-fixed -->
    <div class="container-fluid header-menu">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
            <i class="fa-solid fa-xmark d-none"></i>
        </button>
    </div>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            @foreach ($globalMenus as $item)
            @if($item->children->isNotEmpty())
            <li class="nav-item nav-item-mobile">
                <a href="@if($item->is_click == 1){{ asset($item->url) }}@else javascript:void(0) @endif" target="@if($item->is_tab == 1) _blank @endif">{{ $item->name }}</a>
                <a class="active nav-link-mb" id="nav-link-mb-{{ $item->id }}" aria-current="page" data-id="{{ $item->id }}">
                    <i class="fa-solid fa-chevron-down icon-down"></i>
                    <i class="fa-solid fa-chevron-up icon-up"></i>
                </a>

                <ul class="dropdown-content-mobile bg-mb-{{ $item->id }}" id="dropdown-content-{{ $item->id }}">
                    @foreach ($item->children as $child)
                    @include('cntt.components.partials.child-mobile', ['child' => $child])
                    @endforeach
                </ul>
            </li>
            @else
            <li class="nav-item nav-item-mobile">
                <a href="@if($item->is_click == 1){{ asset($item->url) }}@else javascript:void(0) @endif" target="@if($item->is_tab == 1) _blank @endif">{{ $item->name }}</a>
            </li>
            @endif
            @endforeach
        </ul>
    </div>
</nav>
<!-- end navbar mobile -->
@else
<div class="header-menu pt-1 w-menu">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <span class="hamburger material-icons d-inline d-sm-none" id="menu-mobile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"></path>
                    </svg>
                </span>
            </div>
            <div class="col-lg-3 d-none d-lg-block">
                <div class="prd-cate-header dd-none @if(!request()->is('/')) dn-prd-cate @endif">
                    <span class="py-1-5 ps-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"></path>
                        </svg>
                        Danh mục sản phẩm
                    </span>
                </div>
            </div>
            <div class="col-lg-9 d-none d-lg-block">
                <div class="navbar-content" id="navbarNav">
                    <?php $count = 0 ?>
                    @foreach($globalMenus as $category)
                    <?php $count++; $count ?>
                    @if($category->children->isNotEmpty())
                    <div class="nav-item">
                        <a class="nav-link nav-link-web" href="@if($category->is_click == 1){{ asset($category->url) }}@else javascript:void(0) @endif" target="@if($category->is_tab == 1) _blank @endif" id="navbarDropdown{{ $category->id }}" data-id="{{ $category->id }}">
                            {{ $category->name }} <i class="fa-solid fa-chevron-down"></i>
                        </a>
                        @if(count($category->children) > 0)
                        <div class="dropdown-content dropdown-{{ $category->id }}">
                            <div class="container" style="padding-left: 12px; padding-top: 4px;">
                                @include('cntt.components.partials.children', ['subcategories' => $category->children])
                            </div>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="nav-item">
                        <a class="nav-link" href="@if($category->is_click == 1){{ asset($category->url) }}@else javascript:void(0) @endif" target="@if($category->is_tab == 1) _blank @endif" id="navbarDropdown{{ $category->id }}" data-id="{{ $category->id }}">
                            {{ $category->name }}
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
<div class="container @if(!request()->is('/')) w-child-menu @endif">
    <div class="row">
        <div class="col-lg-3">
            <div id="prd-cate-list">
                <div class="main-cate @if(!request()->is('/')) dn-main-cate @endif">
                    <ul>
                        <?php $countData = 0?>
                        @foreach($globalCategories as $item)
                        <?php $countData++; $countData?>
                        <li class="d-flex justify-content-between align-items-center">
                            <a title="{{ $item->name }}" href="{{ asset('/' . $item->slug) }}">
                                <img width="25" height="25" alt="{{ $item->alt_img }}" src="{{ asset('/' . $item->image) }}">
                                <span>{{ $item->name }}</span>
                            </a>
                            <i class="fa-solid fa-chevron-right"></i>
                            @if($item->is_serve == 1)
                            @php
                                $categories = [
                                    1 => [
                                        'title' => 'Hãng sản xuất',
                                        'icon' => '<i class="fa-solid fa-fire"></i>',
                                        'image' => true, // Có hiển thị ảnh
                                    ],
                                    2 => [
                                        'title' => 'Chassis',
                                        'icon' => '<i class="fa-solid fa-fire"></i>',
                                        'image' => false, // Không hiển thị ảnh
                                    ],
                                    3 => [
                                        'title' => 'Cấu hình',
                                        'icon' => '<i class="fa-solid fa-fire"></i>',
                                        'image' => false, // Không hiển thị ảnh
                                    ],
                                ];
                            @endphp

                            <ul class="dm-server">
                                @foreach($categories as $key => $category)
                                <li class="hang-san-xuat">
                                    <p>{!! $category['title'] !!} {!! $category['icon'] !!}</p>
                                    <ul>
                                        @foreach($item->children as $value)
                                        @if($value->infor_server == $key)
                                        <li>
                                            <a title="{{ $value->name }}" href="{{ asset('/' . $value->slug) }}">
                                                @if($category['image'])
                                                <img width="65" height="20" alt="{{ $value->alt_img }}" src="{{ asset('/' . $value->image) }}">
                                                {{ $value->name }}
                                                @else
                                                <span><i class="fa-solid fa-caret-right"></i> {{ $value->name }}</span>
                                                @endif
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <ul>
                                @foreach($item->children as $val)
                                <li>
                                    <a title="{{ $val->name }}" href="{{ asset('/' . $val->slug) }}">
                                        <img width="65" height="25" alt="{{ $val->alt_img }}" src="{{ asset('/' . $val->image) }}">
                                        <span>{{ $val->name }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            @if(!empty($sliders))
            <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    @php
                    $totalSlider = $sliders->count();
                    @endphp

                    @if($totalSlider > 0)
                    @for($i = 0; $i < $totalSlider; $i++)
                        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}">
                        </li>
                        @endfor
                        @endif
                </ol>
                <div class="carousel-inner">
                    @foreach($sliders as $index => $slider)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img class="img-fluid" loading="lazy" data-src="{{ asset($slider->image) }}" src="{{ asset($slider->image) }}" srcset="{{ asset($slider->image) }}" alt="{{ $slider->name }}">
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endif
<!-- Modal -->
<div class="modal fade bg-search" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="container">
        <div class="modal-dialog modal-lg modal-search" role="document">
            <form method="GET" action="{{ route('home.search') }}" class="modal-content modal-body border-0 p-0">
                <div class="input-group">
                    <div class="form-group">
                        <select name="cate" class="form-control border search-cate">
                            <option value="prod">Tất cả sản phẩm</option>
                            <option value="news">Tất cả bài viết</option>
                            @if(isset($searchCate))
                            @foreach($searchCate as $category)
                            @php
                            $optionValue = $category->source . '_' . $category->id;
                            $isSelected = \Request::get('cate') == $optionValue ? "selected" : "";
                            @endphp
                            <option value="{{ $optionValue }}" {{ $isSelected }}>
                                @if($category->source == 'prod')
                                {{ $category->name }}--Sản phẩm
                                @elseif($category->source == 'news')
                                {{ $category->name }}--Bài viết
                                @endif
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <input type="text" class="form-control" id="inputModalSearch" name="keyword" placeholder="Bạn cần tìm gì?">
                    <button type="submit" class="input-group-text bg-gr text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Close Header -->