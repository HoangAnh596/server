@extends('cntt.layouts.app')

@section('content')
@php
$agent = new Jenssegers\Agent\Agent();
@endphp

<!-- Start Featured Product -->
<div class="container">
    <!-- Begin Sản phẩm nổi bật -->
    <div class="product-outstand">
        <div class="box-title text-center mt-3 mb-3">
            <img width="350px" src="{{ asset('cntt/img/san-pham-noi-bat.gif') }}" alt="Sản phẩm nổi bật">
        </div>
        <div class="owl-carousel owl-theme">
            @foreach($prOutstand as $val)
            <div class="item">
                <div class="card h-100">
                    @php
                    $mainImage = $val->product_images->firstWhere('main_img', 1);
                    @endphp

                    @if($mainImage)
                    @php
                    $imagePath = $mainImage->image;
                    $directory = dirname($imagePath);
                    $filename = basename($imagePath);
                    $newDirectory = $directory . '/small';
                    $newImagePath = $newDirectory . '/' . $filename;
                    @endphp
                    <figure class="img-outstand" data-id="{{ $val->id }}" data-tooltip="sticky3">
                        <a href="{{ asset('/' . $val->slug) }}">
                            <img class="img-size" loading="lazy" width="240" height="169" data-src="{{ asset($newImagePath) }}" src="{{ asset($newImagePath) }}" srcset="{{ asset($newImagePath) }}" alt="{{ $mainImage->alt }}">
                        </a>
                        <div id="{{ $val->id }}" class="description-zoom">
                            <div class="content_pro_toll">
                                <a data-tooltip="sticky3" href="https://cnttshop.vn/dell-emc-poweredge-r440-2.5-inch-1">Máy chủ Dell PowerEdge R440 8x2.5″ (Intel Xeon Silver 4216 / 16GB RAM / 1.2TB HDD SAS )</a>
                                <ul class="thong-so-ky-thuat-sv" data-tooltip="sticky3">
                                    <li>Chassis 1U Dell PowerEdge R440 8x2.5″</li>
                                    <li>Mainboard Dell PowerEdge R440 2.5inch</li>
                                    <li>Dell PERC H740P RAID Controller</li>
                                    <li>1 x Intel Xeon Silver 4216 Processor (16C/32T, 10.4GT/s, 27.5M Cache, 2.1GHz, DDR4-2667)</li>
                                    <li>1 x Heat Sink CPU 2nd Dell PowerEdge R440, APAC</li>
                                    <li>1 x RAM DELL 16GB DDR4-2666 RDIMM PC4-21300V-R Dual Rank x8 Replacement</li>
                                    <li>1 x Ổ Cứng HDD Dell 400-ATJO 1.2TB 10K SAS 12Gbps 512n 2.5inch</li>
                                    <li>1 x Tray Dell Poweredge DXD9H 2.5inch</li>
                                    <li>1 x Broadcom 5719 4-port 1Gb Network Interface Card, Full Height</li>
                                    <li>2 x Power Supply 6V43G Dell PowerEdge 550W</li>
                                </ul>
                            </div>
                        </div>
                    </figure>

                    @endif
                    <div class="card-body owl-outstand">
                        <a href="{{ asset('/' . $val->slug) }}" class="text-decoration-none btn-link">
                            <h3>{{ $val->name }}</h3>
                        </a>
                        <div class="prd-sale">
                            <p class="prd-sale-detail">Nổi bật</p>
                        </div>
                        <div class="config-outstand mt-2 mb-2">
                            <p>
                                <span>Cấu hình: 4x3.5″ Basic</span>
                            </p>
                            @if(!empty($val->cpu_pr))
                            <p title="Hỗ trợ CPU">
                                <img src="{{ asset('cntt/img/cpu.png') }}"> {{ $val->cpu_pr }}
                            </p>
                            @endif
                            @if(!empty($val->ram_pr))
                            <p title="Hỗ trợ RAM">
                                <img src="{{ asset('cntt/img/ram.png') }}"> {{ $val->ram_pr }}
                            </p>
                            @endif
                            @if(!empty($val->hdd_pr))
                            <p title="Ổ đĩa">
                                <img src="{{ asset('cntt/img/hdd.png') }}"> {{ $val->hdd_pr }}
                            </p>
                            @endif
                        </div>
                        <ul class="list-unstyled d-flex justify-content-between">
                            @if($val->price == 0)
                            <li><span class="text-decoration-none lien-he-outstand"> Liên hệ</span></li>
                            @else
                            @if($val->discount != 0)
                            <li>
                                <a href="{{ asset('/' . $val->slug) }}" class="text-decoration-none text-danger">
                                    {{ number_format($val->price * (1 - $val->discount / 100), 0, ',', '.') }}₫
                                </a>
                            </li>
                            <li class="d-flex align-items-start">
                                <a href="{{ asset('/' . $val->slug) }}" class="text-decoration-none price-sale text-secondary">
                                    {{ number_format($val->price, 0, ',', '.') }}₫
                                </a>
                            </li>
                            @else
                            <li>
                                <a href="{{ asset('/' . $val->slug) }}" class="text-decoration-none text-danger">
                                    {{ number_format($val->price, 0, ',', '.') }}₫
                                </a>
                            </li>
                            @endif
                            @endif

                            @if($val->status == 1)
                            <li><span class="lien-he-price"><i class="fa-solid fa-check"></i> Còn hàng</span></li>
                            @else
                            <li></li>
                            @endif
                        </ul>
                        <div class="btn-outstand text-center mt-3">
                            <a href="{{ asset('/' . $val->slug) }}">Xem thông tin</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Begin Sản phẩm -->
    <div class="product-categories mt-4">
        @if(!empty($categoriesWithProducts))
        @foreach ($categoriesWithProducts as $data)
        <div class="row bg-cate mb-3">
            @if(!empty($data['products']))
            <div class="col-md-3 text-cate" style="padding-left: 0;">
                <a class="btn-link ft-sw" href="{{ asset($data['category']->slug) }}" title="{{ $data['category']->name }}">
                    <h2>{{ $data['category']->name }}</h2>
                </a>
            </div>
            <div class="col-md-9 d-flex align-items-center justify-content-end" style="padding-right: 0;">
                <ul class="nav nav-mb">
                    @foreach($data['category']->children as $child)
                    @if($child->is_menu == 1)
                    <li class="nav-item">
                        <a class="btn-link" aria-current="page" href="{{ asset('/' . $child->slug) }}">{{ $child->name }}</a>
                    </li>
                    @endif
                    @endforeach
                    <li class="nav-item">
                        <a class="btn-link" aria-current="page" href="{{ asset($data['category']->slug) }}" title="xem thêm">Xem thêm</a>
                    </li>
                </ul>
            </div>
            @endif
        </div>
        <div class="row custom-row mb-4">
            @if(!empty($data['products']))
            @foreach($data['products'] as $product)
            <div class="col-w-5 col-xs-6 col-md-4 col-sm-6 mb-custom">
                <div class="card h-100">
                    @php
                    $mainImage = $product->product_images->firstWhere('main_img', 1);
                    @endphp

                    @if($mainImage)
                    @php
                    $imagePath = $mainImage->image;
                    $directory = dirname($imagePath);
                    $filename = basename($imagePath);
                    $newDirectory = $directory . '/small';
                    $newImagePath = $newDirectory . '/' . $filename;
                    @endphp
                    <a class="btn-img" href="{{ asset('/' . $product->slug) }}">
                        <img class="img-size" loading="lazy" width="240" height="180" data-src="{{ asset($newImagePath) }}" src="{{ asset($newImagePath) }}" srcset="{{ asset($newImagePath) }}" alt="{{ $mainImage->alt }}" title="{{ $mainImage->title }}">
                    </a>
                    @else
                    <a class="btn-img" href="{{ asset('/' . $product->slug) }}">
                        <img class="img-size" loading="lazy" width="240" height="180" src="{{ asset('storage/images/small/image-coming-soon.jpg') }}" data-src="{{ asset('storage/images/image-coming-soon.jpg') }}" srcset="{{ asset('storage/images/image-coming-soon.jpg') }}" alt="Image Coming Soon" title="Image Coming Soon">
                    </a>
                    @endif
                    <div class="card-body">
                        <a href="{{ asset('/' . $product->slug) }}" class="text-decoration-none btn-link">
                            <h3>{{ $product->name }}</h3>
                        </a>
                        <ul class="list-unstyled d-flex">
                            @if($product->price == 0)
                            <li><span class="lien-he-price"> Liên hệ</span></li>
                            @else
                            @if($product->discount != 0)
                            <li>
                                <a href="{{ asset('/' . $product->slug) }}" class="text-decoration-none text-danger">
                                    {{ number_format($product->price * (1 - $product->discount / 100), 0, ',', '.') }}₫
                                </a>
                            </li>
                            <li class="d-flex align-items-start">
                                <a href="{{ asset('/' . $product->slug) }}" class="text-decoration-none price-sale text-secondary">
                                    {{ number_format($product->price, 0, ',', '.') }}₫
                                </a>
                            </li>
                            @else
                            <li>
                                <a href="{{ asset('/' . $product->slug) }}" class="text-decoration-none text-danger">
                                    {{ number_format($product->price, 0, ',', '.') }}₫
                                </a>
                            </li>
                            @endif
                            @endif
                        </ul>
                        <ul class="list-unstyled d-flex justify-content-between align-items-center total-review-home">
                            <li class="text-muted text-right">
                                <i class="text-warning fa fa-star"></i>
                                <span>
                                    @if ($product->totalCmt > 0)
                                    {{ number_format($product->average_star, 1) }} ({{ $product->totalCmt }})
                                    @endif
                                </span>
                            </li>
                            @if($product->status == 1)
                            <li><span class="lien-he-price"><i class="fa-solid fa-check"></i> Còn hàng</span></li>
                            @else
                            <li></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
        @endforeach
        @endif
    </div>
    <!-- Begin Tin tức bài viết -->
    <div class="row bg-cate mt-2">
        <div class="col-md-3 text-cate" style="padding-left: 0;">
            <a class="btn-link ft-sw" href="{{ asset('/blogs') }}">Tin Tức Công Nghệ</a>
        </div>
        <div class="col-md-9 d-flex align-items-center justify-content-end" style="padding-right: 0;">
            <ul class="nav nav-mb">
                @foreach($cateBlogs as $child)
                <li class="nav-item">
                    <a class="btn-link" aria-current="page" href="{{ asset('/blogs/' . $child->slug) }}">{{ $child->name }}</a>
                </li>
                @endforeach
                <li class="nav-item">
                    <a class="btn-link" aria-current="page" href="{{ asset('/blogs') }}">Xem thêm</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container-fluid px-0 mt-4">
        <div class="owl-carousel owl-theme">
            @if(!empty($blogs))
            @foreach($blogs as $val)
            <div class="item">
                <div class="card h-100 card-new">
                    <a class="btn-img-new" href="{{ asset('/blogs/' . $val->slug) }}">
                        <img class="img-size" loading="lazy" width="294" height="200" src="{{ asset(str_replace('bai-viet/', 'bai-viet/medium/', $val->image)) }}" data-src="{{ asset(str_replace('bai-viet/', 'bai-viet/medium/', $val->image)) }}" srcset="{{ asset(str_replace('bai-viet/', 'bai-viet/medium/', $val->image)) }}" alt="{{ $val->alt_img }}" title="{{ $val->title_img }}">
                    </a>
                    <div class="new-body">
                        <a href="{{ asset('/blogs/' . $val->slug) }}" class="text-decoration-none text-dark">
                            <h4>{{ $val->name }}</h4>
                        </a>
                    </div>
                    <p>{{ $val->desc }}</p>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Begin service -->
<section class="service-section">
    <div class="container">
        <div class="section-title text-center">
            <h2>Tại sao chọn chúng tôi</h2>
            <span class="decor"></span>
        </div>
        <div class="row">
            <div class="service-item col-lg-4 col-md-4 sm-6">
                <div class="icon_box">
                    <img loading="lazy" width="40" height="40" data-src="{{ asset('storage/images/ui_images/icon-tu-van.png') }}" alt="Tư vấn tin cậy" src="{{ asset('storage/images/ui_images/icon-tu-van.png') }}" srcset="{{ asset('storage/images/ui_images/icon-tu-van.png') }}">
                </div>
                <p class="why_us">Tư vấn tin cậy</p>
                <div class="text">
                    <p>Tư vấn, giải đáp mọi thắc mắc</p>
                </div>
            </div>
            <div class="service-item col-lg-4 col-md-4 sm-6">
                <div class="icon_box">
                    <img loading="lazy" width="40" height="40" data-src="{{ asset('storage/images/ui_images/icon-gia.png') }}" alt="Giá cạnh tranh" src="{{ asset('storage/images/ui_images/icon-gia.png') }}" srcset="{{ asset('storage/images/ui_images/icon-gia.png') }}">
                </div>
                <p class="why_us">Giá cả cạnh tranh</p>
                <div class="text">
                    <p>Giá cạnh tranh, thấp nhất thị trường</p>
                </div>
            </div>
            <div class="service-item col-lg-4 col-md-4 sm-6">
                <div class="icon_box">
                    <img loading="lazy" width="40" height="40" data-src="{{ asset('storage/images/ui_images/icon-phuc-vu.png') }}" alt="Phục vụ chu đáo" src="{{ asset('storage/images/ui_images/icon-phuc-vu.png') }}" srcset="{{ asset('storage/images/ui_images/icon-phuc-vu.png') }}">
                </div>
                <p class="why_us">Phục vụ chu đáo</p>
                <div class="text">
                    <p>Đem đến sự hài lòng cho quý khách</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hover vào ảnh của sản phẩm nổi bật -->
<div class="container">
    <div id="mystickytooltip" class="stickytooltip">
        <div class="content_pro_toll">
            <a data-tooltip="sticky3" href="https://cnttshop.vn/dell-emc-poweredge-r440-2.5-inch-1">Máy chủ Dell PowerEdge R440 8x2.5″ (Intel Xeon Silver 4216 / 16GB RAM / 1.2TB HDD SAS )</a>
            <ul class="thong-so-ky-thuat-sv" data-tooltip="sticky3">
                <li>Chassis 1U Dell PowerEdge R440 8x2.5″</li>
                <li>Mainboard Dell PowerEdge R440 2.5inch</li>
                <li>Dell PERC H740P RAID Controller</li>
                <li>1 x Intel Xeon Silver 4216 Processor (16C/32T, 10.4GT/s, 27.5M Cache, 2.1GHz, DDR4-2667)</li>
                <li>1 x Heat Sink CPU 2nd Dell PowerEdge R440, APAC</li>
                <li>1 x RAM DELL 16GB DDR4-2666 RDIMM PC4-21300V-R Dual Rank x8 Replacement</li>
                <li>1 x Ổ Cứng HDD Dell 400-ATJO 1.2TB 10K SAS 12Gbps 512n 2.5inch</li>
                <li>1 x Tray Dell Poweredge DXD9H 2.5inch</li>
                <li>1 x Broadcom 5719 4-port 1Gb Network Interface Card, Full Height</li>
                <li>2 x Power Supply 6V43G Dell PowerEdge 550W</li>
            </ul>
        </div>
    </div>
</div>
<!-- End service -->
@endsection

@section('css')
<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
<style>
    nav .container-fluid {
        padding-top: .5rem;
        padding-bottom: .5rem;
    }

    .owl-carousel .item {
        padding: 4px;
    }

    .owl-carousel .card {
        width: 100%;
        height: auto;
    }

    .owl-carousel .owl-nav button.owl-prev,
    .owl-carousel .owl-nav button.owl-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: #fff;
        box-shadow: 0 0 4px 0 rgba(0, 0, 0, .2);
        opacity: .8;
        outline: none;
        transition: .3s;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .owl-carousel .owl-nav button.owl-prev:hover,
    .owl-carousel .owl-nav button.owl-next:hover {
        background-color: #dc3545;
    }

    .owl-carousel .owl-nav button.owl-prev {
        left: -28px;
    }

    .owl-carousel .owl-nav button.owl-next {
        right: -29px;
    }

    .owl-carousel .owl-stage-outer {
        padding-bottom: 12px;
    }

    .owl-theme .owl-nav {
        margin-top: 0px;
    }

    .owl-theme .owl-dots {
        display: none;
    }

    @media (max-width: 768px) {
        .owl-carousel .owl-nav button.owl-prev {
            left: 0;
            width: 24px;
            height: 24px;
        }

        .owl-carousel .owl-nav button.owl-next {
            right: 0;
            width: 24px;
            height: 24px;
        }

        .owl-carousel .item {
            padding: 0px;
        }
    }
</style>
@endsection
@section('js')
<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="{{ asset('cntt/js/slick.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.cate-autoplay').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4000,
            arrows: false,
            infinite: true
        });
        $(".owl-carousel").owlCarousel({
            items: 5, // Số lượng item hiển thị
            loop: true,
            margin: 6,
            nav: true,
            navText: [
                '<i class="fas fa-chevron-left"></i>', // Nút Previous
                '<i class="fas fa-chevron-right"></i>' // Nút Next
            ],
            autoplay: true, // Bật tự động chạy slide
            autoplayTimeout: 3000, // Chuyển slide mỗi 3 giây
            autoplayHoverPause: true, // Tạm dừng khi di chuột vào
            responsive: {
                0: {
                    items: 2
                },
                800: {
                    items: 3
                },
                1100: {
                    items: 5
                }
            }
        });

        $('.img-outstand').on('mousemove', function (e) {
            const tooltip = $('#mystickytooltip');
            const tooltipId = $(this).data('tooltip');
            let leftPosition = e.pageX + 20;
            
            if (leftPosition > 1100) {
                leftPosition -= 400; // Trừ 200px nếu vượt quá giới hạn
            }
            // Cập nhật vị trí tooltip theo chuột
            tooltip
                .css({
                    top: e.pageY - 200 + 'px',
                    left: leftPosition + 'px',
                    display: 'block',
                })
                .attr('data-tooltip', tooltipId); // Gán dữ liệu tooltip
        });

        $('.img-outstand').on('mouseleave', function () {
            $('#mystickytooltip').hide(); // Ẩn tooltip khi chuột rời ảnh
        });
    });
</script>
@endsection