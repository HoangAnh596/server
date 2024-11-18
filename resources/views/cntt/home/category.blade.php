@extends('cntt.layouts.app')

@section('content')
<div class="pt-44" id="breadcrumb">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                @foreach ($allParents as $parent)
                <li class="breadcrumb-item"><a href="{{ asset($parent->slug) }}">{{ $parent->name }}</a></li>
                @endforeach
                <li class="breadcrumb-item">{{ $mainCate->name }}</li>
            </ol>
        </nav>
    </div>
</div>
<div class="filter">
    <div class="container">
        @php
        $agent = new Jenssegers\Agent\Agent();
        @endphp
        <!-- Header -->
        <!-- begin navbar mobile -->
        @if($agent->isMobile())
        @if(!empty($filterCate))
        <div class="row mt-3">
            <h1>Chọn theo tiêu chí</h1>
        </div>
        <div class="mobile-filter ft-fixed mt-3" data-url="{{ route('home.filters') }}">
            <div class="container" style="padding: 0;">
                <div class="splide">
                    <div class="splide__track">
                        <div class="splide__list">
                            @foreach ($filterCate as $filter)
                            <div class="splide__slide">
                                <button class="filter-item show-filter-mb" name="{{ $filter->slug }}" data-filter-id="{{ $filter->id }}" aria-current="page">{{ $filter->name }} <i class="fa-solid fa-chevron-down"></i></button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($filterCate as $filter)
            <div class="child-filter-mb" data-target="{{ $filter->id }}">
                <ul style="margin:0">
                    @foreach ($filter->valueFilters as $val)
                    <li class="nav-item child-nav" style="padding-bottom: 6px;">
                        <button class="btn-child-filter-mb" id="{{ $val->id }}" aria-current="page" href="javascript:void(0)">{{$val->key_word}}</button>
                    </li>
                    @endforeach
                    <div class="filter-button-mb filter-button-sticky">
                        <button href="javascript:void(0)" class="btn-filter-close-mb">Bỏ chọn</button>
                        <button href="javascript:filterPros();" class="btn-filter-readmore-mb">Xem <b class="total-reloading"> @if(!empty($total)) {{ $total }} @endif</b> kết quả</button>
                    </div>
                </ul>
            </div>
            @endforeach
        </div>
        @endif
        @else
        @if(!empty($filterCate))
        <div class="row web-filter mt-3" data-url="{{ route('home.filters') }}">
            <h1 class="mb-3">Chọn theo tiêu chí</h1>
            <ul class="nav nav-filter ft-fixed">
                <div class="container cont-fixed">
                    <?php $countFilter = 0 ?>
                    @foreach ($filterCate as $fil)
                    <?php $countFilter++;
                    $countFilter ?>
                    <li class="nav-item">
                        @if($fil->top_filter == 1)
                        <button class="filter-item show-filter top-filter" name="{{ $fil->slug }}" aria-current="page">
                            {{ $fil->name }} <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        @elseif($fil->special == 1)
                        <button class="filter-item show-filter special-filter" name="{{ $fil->slug }}" aria-current="page">
                            {{ $fil->name }} <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        @else
                        <button class="filter-item show-filter" name="{{ $fil->slug }}" aria-current="page">
                            {{ $fil->name }} <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        @endif
                        @if ($countFilter > 4 && $countFilter < 8)
                            <ul class="child-filter filter-show-right">
                            <div class="arrow-filter-right"></div>
                            @if($fil->special == 1)
                            @foreach ($fil->valueFilters as $item)
                    <li class="nav-item child-nav">
                        <a class="btn-child-filter" id="{{ $item->id }}" data-href="{{ $item->search }}" href="{{ $cateParent->slug }}?{{ $fil->slug }}={{ $item->id }}" data-type="filters">{{ $item->key_word }}</a>
                    </li>
                    @endforeach
                    @endif
                    @foreach ($fil->valueFilters as $item)
                    <li class="nav-item child-nav">
                        <a class="btn-child-filter" id="{{ $item->id }}" data-href="{{ $item->search }}" href="{{ $cateParent->slug }}-{{ $item->search }}" data-type="filters">{{ $item->key_word }}</a>
                    </li>
                    @endforeach
                    <div class="filter-button filter-button-sticky">
                        <button href="javascript:void(0)" id="{{ $fil->id }}" class="btn-filter-close">Bỏ chọn</button>
                        <button href="javascript:filterPros();" id="{{ $fil->id }}" class="btn-filter-readmore">Xem <b class="total-reloading"> @if(!empty($total)) {{ $total }} @endif</b> kết quả</button>
                    </div>
            </ul>
            @else
            <ul class="child-filter">
                <div class="arrow-filter"></div>
                @if($fil->special == 1)
                @foreach ($fil->valueFilters as $item)
                <li class="nav-item child-nav">
                    <a class="btn-child-filter" id="{{ $item->id }}" data-href="{{ $item->search }}" href="{{ $cateParent->slug }}?{{ $fil->slug }}={{ $item->id }}" data-type="filters">{{ $item->key_word }}</a>
                </li>
                @endforeach
                @else
                @foreach ($fil->valueFilters as $item)
                <li class="nav-item child-nav">
                    <a class="btn-child-filter" id="{{ $item->id }}" data-href="{{ $item->search }}" href="{{ $cateParent->slug }}-{{ $item->search }}" data-type="filters">{{ $item->key_word }}</a>
                </li>
                @endforeach
                @endif
                <div class="filter-button filter-button-sticky">
                    <button href="javascript:void(0)" id="{{ $fil->id }}" class="btn-filter-close">Bỏ chọn</button>
                    <button href="javascript:filterPros();" id="{{ $fil->id }}" class="btn-filter-readmore">Xem <b class="total-reloading"> @if(!empty($total)) {{ $total }} @endif</b> kết quả</button>
                </div>
            </ul>
            @endif
            </li>
            @endforeach
        </div>
        @endif
        @endif
    </div>
</div>

<div class="container">
    <div class="show-prod-cate">
        <h2 class="mt-3">{{ $mainCate->name }}</h2>
        <div class="row custom-row mt-3" id="product-data">
            @include('cntt.home.partials.products', ['products' => $products])
        </div>
        <nav class="d-flex justify-content-center mt-3">
            {{ $products->links() }}
        </nav>
    </div>
    <div class="cate-prod mt-3">
        <div class="row">
            <div class="col-md-9 res-w100">
                <div class="content-cate mb-3">
                    <div>
                        {!! $mainCate->content !!}
                    </div>
                    <div class="align-items-center justify-content-center btn-show-more show-more pb-3">
                        <button class="btn-link">Xem thêm <i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                </div>
                @if ($mainCate->questionCate->isNotEmpty())
                <div class="box-question mb-3" id="boxFAQ">
                    <p class="title">Câu hỏi thường gặp</p>
                    <div class="accordion">
                        @foreach($mainCate->questionCate as $question)
                        <div class="mb-1">
                            <div class="b-button button__show-faq">
                                <p>{{ $question->title }}</p>
                                <div class="icon"><svg height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                        <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="accordion__content">
                                <div class="content-wrapper">{!! $question->content !!}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <div class="col-md-3 res-dnone">
                @if(!$prOutstand->isEmpty())
                <div class="outstand-prod mb-3">
                    <div class="bg-prod d-flex align-items-center">
                        <h2><i class="fa-brands fa-gripfire"></i> Sản phẩm nổi bật</h2>
                    </div>
                    <div class="title-outstand-prod">
                        @foreach($prOutstand as $data)
                        <div class="row mt-3">
                            <div class="col-md-4 col-4" style="padding:0;">
                                @php
                                $mainImage = $data->product_images->firstWhere('main_img', 1);
                                @endphp

                                @if($mainImage)
                                @php
                                $imagePath = $mainImage->image;
                                $directory = dirname($imagePath);
                                $filename = basename($imagePath);
                                $newDirectory = $directory . '/small';
                                $newImagePath = $newDirectory . '/' . $filename;
                                @endphp
                                <a class="btn-img-outs" href="{{ $data->slug }}">
                                    <img class="img-size" loading="lazy" width="100" height="75" src="{{ asset($newImagePath) }}" alt="{{ $mainImage->alt }}" title="{{ $mainImage->title }}">
                                </a>
                                @else
                                <a class="btn-img-outs" href="{{ $data->slug }}">
                                    <img class="img-size" loading="lazy" width="100" height="75" src="{{ asset('storage/images/small/image-coming-soon.jpg') }}" data-src="{{ asset('storage/images/image-coming-soon.jpg') }}" alt="Image Coming Soon" title="Image Coming Soon">
                                </a>
                                @endif
                            </div>
                            <div class="col-md-8 col-8 d-flex flex-column bd-highlight text-outstand">
                                <div class="bd-highlight r-2">
                                    <a class="btn-link" href="{{ $data->slug }}">{{ $data->name }}</a>
                                </div>
                                <div class="mt-auto bd-highlight">
                                    <ul class="list-unstyled d-flex justify-content-between align-items-center total-review-home infor-outs">
                                        <li>
                                            @if($data->price == 0)
                                            <span class="lien-he-price">Liên hệ</span>
                                            @else
                                            <a href="{{ $data->slug }}" class="text-decoration-none text-danger">
                                                {{ number_format($data->discount != 0 ? $data->price * (1 - $data->discount / 100) : $data->price, 0, ',', '.') }}₫
                                            </a>
                                            @endif
                                        </li>
                                        <li class="text-muted text-right">
                                            <i class="text-warning fa fa-star"></i>
                                            <span>
                                                @if ($data->totalCmt > 0)
                                                {{ number_format($data->average_star, 1) }} ({{ $data->totalCmt }})
                                                @endif
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="align-items-center justify-content-center nav-mb outstand-show-more btn-show-more pb-3">
                            <button class="btn-link">Xem thêm <i class="fa-solid fa-chevron-down"></i></button>
                        </div>
                    </div>
                </div>
                @endif
                <!-- Hotline -->
                <div class="support-prod new-prod mb-3">
                    <div class="bg-prod d-flex align-items-center">
                        <h2><i class="fa-solid fa-file-invoice-dollar"></i> Bạn cần báo giá tốt nhất</h2>
                    </div>
                    <div class="title-outstand-prod">
                        <div class="row mt-3">
                            <div><span class="top-heading">Hỗ trợ kinh doanh <i class="fa-solid fa-money-check-dollar"></i></span></div>
                            @foreach($phoneInfors as $val)
                            @if($val->role == 0)
                            <div class="contact-infor">
                                <span class="user-heading"><i class="fa-solid fa-user-check"></i> {{ $val->name }}</span>
                                <div class="sp-online">
                                    <span title="Mobile"><i class="fa-solid fa-headset"></i> {{ $val->phone }}</span>

                                    <a href="{{ $val->skype }} " title="Chat với {{ $val->name }} qua Skype">
                                        <i class="i-skype"></i>
                                    </a>
                                    <a href="https://zalo.me/{{ $val->zalo }} " title="Chat {{ $val->name }} qua Zalo">
                                        <i class="i-zalo"></i>
                                    </a>
                                    <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }} " title="Gửi mail tới: {{ $val->name }} ">
                                        <i class="i-gmail"></i>
                                    </a>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            <div class="mt-3"><span class="top-heading">Hỗ trợ kỹ thuật <i class="fa-solid fa-gear"></i></span></div>
                            @foreach($phoneInfors as $val)
                            @if($val->role == 1)
                            <div class="contact-infor">
                                <span class="user-heading"><i class="fa-solid fa-user-check"></i> {{ $val->name }}</span>
                                <div class="sp-online">
                                    <span title="Mobile"><i class="fa-solid fa-headset"></i> {{ $val->phone }}</span>

                                    <a href="{{ $val->skype }} " title="Chat với {{ $val->name }} qua Skype">
                                        <i class="i-skype"></i>
                                    </a>
                                    <a href="https://zalo.me/{{ $val->zalo }} " title="Chat {{ $val->name }} qua Zalo">
                                        <i class="i-zalo"></i>
                                    </a>
                                    <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }} " title="Gửi mail tới: {{ $val->name }} ">
                                        <i class="i-gmail"></i>
                                    </a>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('cntt/css/category.css')}}">
<link rel="stylesheet" href="{{asset('cntt/css/content.css')}}">
<link rel="stylesheet" href="{{asset('cntt/css/catePro.css')}}">
@endsection
@section('js')
<script src="{{ asset('cntt/js/category.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script type="text/javascript">
    // Nhúng danh sách slugs từ backend vào frontend
    var validSlugs = <?php echo json_encode($slugs); ?>;

    function getValidSlugFromUrl(validSlugs) {
        var currentUrl = window.location.href.split('?')[0];
        for (var i = 0; i < validSlugs.length; i++) {
            if (currentUrl.includes(validSlugs[i])) {
                return validSlugs[i];
            }
        }
        return null;
    }
    // Lấy slug hợp lệ từ URL
    var slug = getValidSlugFromUrl(validSlugs);
    document.addEventListener('DOMContentLoaded', function() {
        // Kiểm tra kích thước màn hình khi trang tải
        if (window.innerWidth < 1200) {
            // Tìm phần tử Splide
            var splideElement = document.querySelector('.splide');

            // Chỉ khởi tạo Splide nếu phần tử Splide tồn tại
            if (splideElement) {
                new Splide(splideElement, {
                    perPage: 1,
                    rewind: true,
                    pagination: false,
                    arrows: false,
                }).mount();
            }
        }
        var selectedFiltersMb = {};
        $(document).on('click', '.show-filter-mb', function(e) {
            e.preventDefault();
            var $showFilter = $(this); // Lấy nút show-filter được nhấp
            var index = $('.show-filter-mb').index($showFilter); // Lấy chỉ số của nút show-filter được nhấp
            var $childFilter = $('.child-filter-mb').eq(index); // Lấy child-filter tương ứng

            // Kiểm tra xem child-filter hiện đang hiển thị hay ẩn
            if ($childFilter.is(':visible')) {
                $childFilter.hide(); // Nếu đang hiển thị, thì ẩn đi
                $showFilter.removeClass('border-blue'); // Xóa border-blue nếu đang ẩn
            } else {
                // Ẩn tất cả các child-filter khác và xóa border-blue từ các show-filter không có btn-child-filter nào được chọn
                $('.child-filter-mb').each(function(i) {
                    var $siblingChildFilter = $(this);
                    var $siblingShowFilter = $('.show-filter-mb').eq(i);

                    // Kiểm tra nếu child-filter hiện tại đang hiển thị và không có btn-child-filter-mb nào được chọn
                    if ($siblingChildFilter.is(':visible') && $siblingChildFilter.find('.btn-child-filter-mb.border-blue').length === 0) {
                        $siblingChildFilter.hide(); // Ẩn child-filter hiện tại
                        $siblingShowFilter.removeClass('border-blue'); // Xóa border-blue từ nút show-filter-mb tương ứng
                    }
                });

                $childFilter.show(); // Hiển thị child-filter tương ứng
                $showFilter.addClass('border-blue'); // Thêm border-blue cho nút hiện tại
            }
        });

        // Đóng menu thả xuống khi nhấp vào bên ngoài
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.show-filter-mb, .child-filter-mb').length) {
                $('.child-filter-mb').slideUp(); // Ẩn tất cả các child-filter
                $('.show-filter-mb').each(function() {
                    var $showFilter = $(this);
                    var index = $('.show-filter-mb').index($showFilter); // Lấy chỉ số của nút show-filter
                    var $childFilter = $('.child-filter-mb').eq(index); // Lấy child-filter tương ứng

                    // Kiểm tra nếu không có btn-child-filter-mb nào được chọn
                    if ($childFilter.find('.btn-child-filter-mb.border-blue').length === 0) {
                        $showFilter.removeClass('border-blue'); // Xóa border-blue nếu không có btn-child-filter nào được chọn
                    }
                });
            }
        });

        // Thêm hoặc loại bỏ lớp border-blue khi nhấp vào btn-child-filter
        $('.btn-child-filter-mb').on('click', function(e) {
            e.preventDefault();
            var $btnChildFilter = $(this);
            $btnChildFilter.toggleClass('border-blue');
            $(this).closest('.child-filter-mb').find('.filter-button-mb').show();

            // Lấy giá trị data-target của .child-filter để tìm .show-filter tương ứng
            var targetId = $(this).closest('.child-filter-mb').data('target');

            // Tìm phần tử .show-filter trong tất cả các phần tử .splide__slide
            var $showFilter = $('.splide__slide').find('.show-filter-mb').filter(function() {
                return $(this).data('filter-id') === targetId;
            });
            var filterName = $showFilter.attr('name');
            var filterValue = $btnChildFilter.attr('id');

            if ($btnChildFilter.hasClass('border-blue')) {
                // Nếu được chọn, thêm giá trị vào danh sách các bộ lọc đã chọn
                if (!selectedFiltersMb[filterName]) {
                    selectedFiltersMb[filterName] = [];
                }
                selectedFiltersMb[filterName].push(filterValue);
            } else {
                // Nếu bị bỏ chọn, xóa giá trị khỏi danh sách các bộ lọc đã chọn
                var index = selectedFiltersMb[filterName].indexOf(filterValue);
                if (index > -1) {
                    selectedFiltersMb[filterName].splice(index, 1);
                }
                if (selectedFiltersMb[filterName].length === 0) {
                    delete selectedFiltersMb[filterName]; // Xóa bộ lọc nếu không còn giá trị nào
                }
            }

            // Gọi AJAX để gửi các bộ lọc đã chọn tới backend
            var filterUrlMb = $('.mobile-filter').data('url');
            $.ajax({
                url: filterUrlMb, // Đổi URL thành route xử lý filter của bạn
                type: 'GET',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    filters: selectedFiltersMb
                },
                success: function(response) {
                    // Xử lý phản hồi từ backend (ví dụ: cập nhật danh sách sản phẩm)
                    var $resultCount = $('.total-reloading');
                    var $readMoreButton = $('.btn-filter-readmore-mb');

                    $resultCount.text(response.count);

                    if (response.count === 0) {
                        $readMoreButton.prop('disabled', true); // Vô hiệu hóa nút nếu total bằng 0
                        $readMoreButton.addClass('disabled'); // Thêm lớp 'disabled' để áp dụng CSS
                    } else {
                        $readMoreButton.prop('disabled', false); // Kích hoạt nút nếu total khác 0
                        $readMoreButton.removeClass('disabled'); // Xóa lớp 'disabled' nếu có
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        // Ẩn tất cả các child-filter khi người dùng cuộn trang
        $(window).on('scroll', function() {
            $('.child-filter-mb').hide();
            $('.show-filter-mb').each(function() {
                var $showFilter = $(this);
                var $childFilter = $showFilter.next('.child-filter-mb');
                if ($childFilter.find('.btn-child-filter-mb.border-blue').length === 0) {
                    $showFilter.removeClass('border-blue'); // Xóa border-blue nếu không có btn-child-filter nào được chọn
                }
            });
        });

        // Xử lý nút "Bỏ chọn"
        $('.btn-filter-close-mb').on('click', function() {
            // Tìm .child-filter tương ứng với nút "Bỏ chọn"
            var $childFilter = $(this).closest('.child-filter-mb');
            // Lấy targetId từ .child-filter
            var targetId = $childFilter.data('target');

            // Tìm .show-filter tương ứng với targetId
            var $showFilter = $('.show-filter-mb').filter(function() {
                return $(this).data('filter-id') == targetId;
            });
            var filterName = $showFilter.attr('name');
            delete selectedFiltersMb[filterName]; // Xóa bộ lọc đã chọn
            $childFilter.find('.btn-child-filter-mb').removeClass('border-blue'); // Xóa border-blue từ tất cả btn-child-filter
            $childFilter.hide();
            $showFilter.removeClass('border-blue'); // Xóa border-blue từ show-filter tương ứng
            // Cập nhật URL
            var queryParams = Object.keys(selectedFiltersMb).map(function(key) {
                return key + '=' + selectedFiltersMb[key].join(',');
            }).join('&');

            var currentUrl = window.location.href.split('?')[0]; // Lấy URL hiện tại mà không có query parameters
            var newUrl = currentUrl + (queryParams ? '?' + queryParams : '');
            window.location.href = newUrl;
        });

        // Xử lý nút "Xem kết quả"
        $('.btn-filter-readmore-mb').on('click', function() {
            var queryParams = Object.keys(selectedFiltersMb).map(function(key) {
                return key + '=' + selectedFiltersMb[key].join(',');
            }).join('&'); // Chuyển đổi đối tượng bộ lọc đã chọn thành chuỗi query parameters

            var currentUrl = window.location.href.split('?')[0];
            var newUrl = currentUrl + '?' + queryParams;
            window.location.href = newUrl; // Chuyển hướng đến URL mới
        });

        // Khởi tạo trạng thái ban đầu từ query parameters
        function initFiltersMbFromUrl() {
            var queryParams = new URLSearchParams(window.location.search);

            queryParams.forEach(function(value, key) {
                var values = value.split(',');
                selectedFiltersMb[key] = values;

                // Tìm và thêm class border-blue cho nút show-filter-mb tương ứng
                var $showFilter = $('.show-filter-mb[name="' + key + '"]');
                $showFilter.addClass('border-blue');
                values.forEach(function(id) {
                    var $btnChildFilter = $('.btn-child-filter-mb[id="' + id + '"]');
                    $btnChildFilter.addClass('border-blue');
                });
                // Hiển thị filter-button nếu có bất kỳ btn-child-filter nào được chọn
                var $childFilter = $('.child-filter-mb[data-target="' + key + '"]');
                if (values.length > 0) {
                    $childFilter.show();
                    $childFilter.find('.filter-button-mb').show();
                }
            });
        }

        initFiltersMbFromUrl();
    });

    // Kiểm tra kích thước màn hình khi cửa sổ thay đổi kích thước
    window.addEventListener('resize', function() {
        if (window.innerWidth < 1200) {
            // Tìm phần tử Splide
            var splideElement = document.querySelector('.splide');

            // Chỉ khởi tạo Splide nếu phần tử Splide tồn tại và chưa được khởi tạo
            if (splideElement && !splideElement.classList.contains('is-initialized')) {
                new Splide(splideElement, {
                    perPage: 1,
                    rewind: true,
                    pagination: false,
                    arrows: false,
                }).mount();

                // Đánh dấu phần tử đã được khởi tạo
                splideElement.classList.add('is-initialized');
            }
        }
    });
</script>
@endsection