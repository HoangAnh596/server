@section('css')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<link rel="stylesheet" href="{{ asset('cntt/css/product.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{asset('cntt/css/content.css')}}">
<link rel="stylesheet" href="{{asset('cntt/css/catePro.css')}}">
<link rel="stylesheet" href="{{ asset('cntt/css/compare.css') }}">

<style>
    .modal-header h5 {
        font-size: 16px;
    }
</style>
@endsection
@extends('cntt.layouts.app')

@section('content')

<div class="pt-44">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                @foreach ($allParents as $key)
                <li class="breadcrumb-item"><a href="{{ asset($key->slug) }}">{{ $key->name }}</a></li>
                @endforeach
                <li class="breadcrumb-item"><a href="{{ asset($parent->slug) }}">{{ $parent->name }}</a></li>
                <li class="breadcrumb-item">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container">
    <div class="row mt-4 equal-height">
        <div class="col-lg-9">
            <div class="chi-tiet-sp">
                <div class="row">
                    <div class="col-lg-6">
                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                            <div class="swiper-wrapper">
                                @if(!empty($images))
                                @foreach ($images as $val)
                                @php
                                $imagePath = $val->image;
                                $directory = dirname($imagePath);
                                $filename = basename($imagePath);
                                $newDirectory = $directory . '/large';
                                $newImagePath = $newDirectory . '/' . $filename;
                                @endphp
                                <div class="swiper-slide gallery-trigger">
                                    <img class="prod-img lazyload" src="{{ asset($newImagePath) }}" alt="{{ $val->alt }}" title="{{ $val->title }}">
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <div class="view-more-image">
                            @if($product->main_image)
                            <button href="#" class="pop-gallery">
                                <img alt="Xem 6 ảnh sản phẩm" width="96" height="72" class="" src="{{ asset(str_replace('storage/images/san-pham/', 'storage/images/san-pham/small/', $product->main_image->image)) }}">
                                <div class="over-gallery">Xem {{ count($totalImgCount) }} hình</div>
                            </button>
                            @endif
                        </div>

                        <div id="imageModal" class="modal">
                            <button class="close btn btn-success">x Đóng</button>
                            <div class="modal-content">
                                @if(!empty($images))
                                @foreach($images as $image)
                                <img class="modal-image lazyload" src="{{ asset($image->image) }}" data-src="{{ asset($image->image) }}" alt="{{ $image->alt }}" title="{{ $image->title }}">
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-viewmore-item">
                            <i class="fa-solid fa-comments"></i>
                            <div class="title-spec">
                                <a href="#comment-box" class="scrollToRateBox">
                                    @if($totalCommentsCount != 0) {{ $totalCommentsCount }} @else Thêm @endif bình luận</a>
                            </div>
                        </div>
                        <div class="col-viewmore-item">
                            <i class="fa-solid fa-star"></i>
                            <div class="title-spec">
                                <a href="#comment-box" class="scrollToRateBox">
                                    @if($totalStarCount != 0) {{ $totalStarCount }} @else Thêm @endif đánh giá</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content-des">
                            <h1>{{ $product->name }}</h1>
                            <div class="product-des">{!! $product->des !!}</div>
                            <div class="fk-main">
                                <span><span style="font-weight: bold;">✓</span> Mã sản phẩm:</span>
                                <span>{{ $product->code }}</span>
                            </div>
                            <div class="fk-main">
                                <span><span style="font-weight: bold;">✓</span> Tình trạng:</span>
                                <span>@if($product->status == 1) Còn hàng @else Hết hàng @endif</span>
                            </div>
                            <div class="price">
                                <button title="Liên hệ để để được báo giá bán tốt nhất!" class="contact-price" data-bs-toggle="modal" data-bs-target="#priceModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-hand-index-thumb" viewBox="0 0 16 16">
                                        <path d="M6.75 1a.75.75 0 0 1 .75.75V8a.5.5 0 0 0 1 0V5.467l.086-.004c.317-.012.637-.008.816.027.134.027.294.096.448.182.077.042.15.147.15.314V8a.5.5 0 0 0 1 0V6.435l.106-.01c.316-.024.584-.01.708.04.118.046.3.207.486.43.081.096.15.19.2.259V8.5a.5.5 0 1 0 1 0v-1h.342a1 1 0 0 1 .995 1.1l-.271 2.715a2.5 2.5 0 0 1-.317.991l-1.395 2.442a.5.5 0 0 1-.434.252H6.118a.5.5 0 0 1-.447-.276l-1.232-2.465-2.512-4.185a.517.517 0 0 1 .809-.631l2.41 2.41A.5.5 0 0 0 6 9.5V1.75A.75.75 0 0 1 6.75 1zM8.5 4.466V1.75a1.75 1.75 0 1 0-3.5 0v6.543L3.443 6.736A1.517 1.517 0 0 0 1.07 8.588l2.491 4.153 1.215 2.43A1.5 1.5 0 0 0 6.118 16h6.302a1.5 1.5 0 0 0 1.302-.756l1.395-2.441a3.5 3.5 0 0 0 .444-1.389l.271-2.715a2 2 0 0 0-1.99-2.199h-.581a5.114 5.114 0 0 0-.195-.248c-.191-.229-.51-.568-.88-.716-.364-.146-.846-.132-1.158-.108l-.132.012a1.26 1.26 0 0 0-.56-.642 2.632 2.632 0 0 0-.738-.288c-.31-.062-.739-.058-1.05-.046l-.048.002zm2.094 2.025z"></path>
                                    </svg>
                                    <span>Giá bán liên hệ</span>
                                </button>
                                <a title="Xem giá list sản phẩm {{ $product->code }}" class="check-list-btn" target="_blank" href="{{ asset('/gia-list?key='. $product->code) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                        <path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"></path>
                                    </svg> Check Giá List
                                </a>
                            </div>
                            @if(!empty($product->filepath))
                            <a class="datasheet-prd" title="Datasheet {{ $product->code }}" href="{{ asset($product->filepath) }}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-file-earmark-bar-graph" viewBox="0 0 16 16">
                                    <path d="M10 13.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v6zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z"></path>
                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"></path>
                                </svg>
                                <span>{{ $product->code }} Datasheet</span>
                            </a>
                            @else
                            <a class="datasheet-prd" title="Datasheet {{ $product->code }}" href="javascript:void(0)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-file-earmark-bar-graph" viewBox="0 0 16 16">
                                    <path d="M10 13.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v6zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z"></path>
                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"></path>
                                </svg>
                                <span>{{ $product->code }} Datasheet</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="compare">
                    <div class="tcpr">
                        <p>So sánh với các sản phẩm {{ $parentCate->name }} khác:</p>
                        <div class="sggProd">
                            <form action="javascript:void(0)">
                                @csrf
                                <input type="hidden" id="productId" value="{{ $product->id }}">
                                <input type="hidden" id="slugPro" value="{{ $product->slug }}">
                                <input id="searchSggCP" value="" type="text" placeholder="Nhập Tên hoặc Mã sản phẩm để so sánh" onkeyup="fetchProducts()">
                                <button title="So sánh với sản phẩm khác" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                                    </svg>
                                </button>
                                <div id="compareResults">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="cam-ket-sp">
                <div class="product-note">
                    <p class="cam_ket"><i class="uytin"></i> Cam Kết Bán Hàng</p>
                    <p><span style="font-weight: bold;">✓</span> Sản Phẩm Chính Hãng 100% Đầy Đủ CO/CQ</p>
                    <p><span style="font-weight: bold;">✓</span> Giá Cạnh Tranh Rẻ Nhất Thị Trường</p>
                    <p><span style="font-weight: bold;">✓</span> Ưu Đãi Lớn Cho Đại Lý Và Dự Án</p>
                    <p><span style="font-weight: bold;">✓</span> Bảo Hành, Đổi Trả Nhanh Chóng</p>
                    <p><span style="font-weight: bold;">✓</span> Giao Hàng Trên Toàn Quốc</p>
                    <p><span style="font-weight: bold;">✓</span> Hỗ Trợ Kỹ Thuật Chuyên Nghiệp, Nhiệt Tình</p>
                    <p><span style="font-weight: bold;">✓</span> Chăm Sóc Khách Hàng Trước, Trong và Sau Khi Mua Hàng Tận Tâm.</p>
                    <p class="uytin-10"><b>Nvidiavn.vn</b> - 19 năm Uy tín cung cấp Thiết bị mạng &amp; Dịch vụ Mạng trên toàn quốc.</p>
                    <span class="addhn">
                        <i class="fa-solid fa-location-dot"></i> NTT03, Thống Nhất Complex, Thanh Xuân, <b>Hà Nội</b>.
                        <a title="Chỉ đường đến Nvidiavn.vn" href="https://www.google.com/maps/dir//C%C3%B4ng+ty+Vi%E1%BB%87t+Th%C3%A1i+D%C6%B0%C6%A1ng+-+CNTTShop.vn+-+Ph%C3%A2n+ph%E1%BB%91i+Cisco,+NTT+03,+Line+1,+Th%E1%BB%91ng+Nh%E1%BA%A5t+Complex,+%C4%90%C6%B0%E1%BB%9Dng+Nguy%E1%BB%85n+Tu%C3%A2n,+Thanh+Xu%C3%A2n,+H%C3%A0+N%E1%BB%99i,+Vi%E1%BB%87t+Nam/@21.0017807,105.808972,15z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3135ac8d687d3479:0x863cceda2da3be36!2m2!1d105.8049987!2d20.9977409?hl=vi" target="_blank" rel="noopener noreferrer"><i class="directions"></i></a>
                    </span>
                    <span class="addhnhcm">
                        <i class="fa-solid fa-location-dot"></i> Số 31B, Đường 1, Phường An Phú, Quận 2 (Thủ Đức), <b>TP HCM</b>.
                        <a title="Chỉ đường đến Nvidiavn.vn" href="https://www.google.com/maps/dir//31b+%C4%90%C6%B0%E1%BB%9Dng+s%E1%BB%91+1,+An+Ph%C3%BA,+Qu%E1%BA%ADn+2,+Th%C3%A0nh+ph%E1%BB%91+H%E1%BB%93+Ch%C3%AD+Minh,+Vietnam/@10.8088314,106.7506978,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x31752641f7cf5b8b:0x5573c2cda7b199cb!2m2!1d106.7528865!2d10.8088261?hl=vi" target="_blank" rel="noopener noreferrer"><i class="directions"></i></a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-9 mt-4">
            <div class="content-product mb-3">
                <div id="chi-tiet">{!! $product->content !!}</div>
                <div class="align-items-center justify-content-center btn-show-more show-more pb-3">
                    <button class="btn-link">Xem thêm <i class="fa-solid fa-chevron-down"></i></button>
                </div>
            </div>
            @if ($product->questionProduct->isNotEmpty())
            <div class="box-question mb-3" id="boxFAQ">
                <p class="title">Câu hỏi thường gặp</p>
                <div class="accordion">
                    @foreach($product->questionProduct as $question)
                    <div class="mb-1">
                        <div class="b-button button__show-faq">
                            <p>{{ $question->title }}</p>
                            <div class="icon"><svg height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path>
                                </svg></div>
                        </div>
                        <div class="accordion__content">
                            <div class="content-wrapper">{!! $question->content !!}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <!-- Nhóm sản phẩm đi kèm -->
            @if($groupProducts->isNotEmpty())
            <h3 class="mt-4 panel-heading">
                {{ $parentCate->is_serve == 1 ? "Cấu hình tùy biến cho $product->code" : "Các sản phẩm mua kèm sử dụng cho $product->code" }}
            </h3>
            @endif

            @foreach($groupProducts as $group)
            @if($parentCate->is_serve == 1)
            <div class="panel-subheading">
                <h4>{{ $group->name }}</h4>
                <ul class="conf-section__list">
                    @foreach($group->products as $grPro)
                    @if($group->is_type == 0)
                    <li class="conf-section__item specify is-checked">
                        <label class="radio">
                            <input class="radio__default js-option-item item-{{ $group->name }}" type="radio" id="{{ $group->name }}-{{ $grPro->id }}" name="{{ $group->name }}" data-item="{{ $grPro->id }}" @if($grPro->pivot->is_checked == 1) checked @endif>
                            <span class="radio__custom"></span>
                            <span class="radio__label">
                                <span class="js-item-name">{{ $grPro->name }}</span>
                            </span>
                        </label>
                        <div class="item-price item-price--specify"><span class="item-price__value2">Liên hệ</span></div>
                    </li>
                    @else
                    <li class="conf-section__item with-quantity">
                        <label class="checkbox">
                            <input class="checkbox__default js-option-item item-sled" type="checkbox" id="{{ $group->name }}-{{ $grPro->id }}" name="{{ $group->name }}" data-item="{{ $grPro->id }}">
                            <span class="checkbox__custom"></span>
                            <span class="checkbox__label">
                                <span class="js-item-name">{{ $grPro->name }}</span>
                            </span>
                        </label>
                        <div class="item-price item-price--quantity">
                            <span class="item-price__quantity">
                                <span class="price__quantity-block">
                                    <span class="js-item-counter-minus"></span>
                                    <input aria-label="count" class="js-item-counter item-sled-counter" type="number" step="1" max="10" min="1" value="1">
                                    <span class="js-item-counter-plus"></span>
                                </span>
                                <span class="price__quantity-ea">ea.</span>
                            </span>
                            <span class="item-price__value">Liên hệ</span>
                        </div>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
            @else
            <div class="pricing prd_di_kem group-prod">
                <div class="panel-subheading">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"></path>
                    </svg>
                    <h4>{{ $group->name }}</h4>
                </div>
                <ul>
                    @foreach($group->products as $index => $grPro)
                    <li class="{{ $loop->index % 2 == 0 ? 'mg-r4' : 'mg-r' }}">
                        @if($grPro->getMainImage())
                        <img width="76" height="54" src="{{ asset($grPro->getMainImage()->image) }}" data-src="{{ asset($grPro->getMainImage()->image) }}" data-srcset="{{ asset($grPro->getMainImage()->image) }}" alt="{{ asset($grPro->getMainImage()->alt) }}" title="{{ asset($grPro->getMainImage()->title) }}" srcset="{{ asset($grPro->getMainImage()->image) }}">
                        @else
                        <img width="76" height="54" src="{{ asset('storage/images/image-coming-soon.jpg') }}" data-src="{{ asset('storage/images/image-coming-soon.jpg') }}" alt="Image Coming Soon" title="Image Coming Soon">
                        @endif
                        <a href="{{ asset($grPro->slug) }}">
                            <h4>{{ $grPro->name }}</h4>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="align-items-center justify-content-center nav-mb group-show-more pb-4">
                    <button class="btn-group-prod">Xem thêm <i class="fa-solid fa-chevron-down"></i></button>
                </div>
            </div>
            @endif
            @endforeach

            <!-- Bình luận -->
            <div class="wrap-tab-comments mt-4" id="comment-box">
                <div class="comment-write" id="rate-box">
                    <h3>Bạn đang cần tư vấn về sản phẩm: {{ $product->code }} ?</h3>
                    <div class="form-comment">
                        <form id="rate-form" method="post">
                            @csrf
                            <input type="hidden" id="idUser" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" id="idprd" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" id="slugPrd" name="slugPrd" value="{{ $product->slug }}">
                            <div class="input-account-form cmt-content-form">
                                <textarea title="Nhập nội dung bình luận / nhận xét" name="content" id="comment-content" placeholder="Nhập câu hỏi / bình luận / nhận xét tại đây..." class="info-form-comment"></textarea>
                                <span id="content-error" style="color: red;"></span>
                                <span>
                                    Bạn đang cần tư vấn về sản phẩm {{ $product->code }} và giải pháp mạng? Vui lòng để lại số điện thoại hoặc lời nhắn, nhân viên Nvidiavn.vn sẽ liên hệ trả lời bạn sớm nhất.
                                </span>
                            </div>
                            <div class="input-account-form" id="review-info-pad">
                                <div id="review-info" style="display: none">
                                    <p>Cung cấp thông tin cá nhân</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Họ và tên:</label>
                                                <input type="text" name="name" id="comment-name" class="form-control" value="{{ old('name') }}" placeholder="Nhập họ và tên">
                                                <span id="name-error" style="color: red;"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email:</label>
                                                <input type="text" name="email" id="comment-email" class="form-control" value="{{ old('email') }}" placeholder="Nhập Email (nhận thông báo phản hồi)">
                                                <span id="email-error" style="color: red;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rate-stars-row">
                                    <span class="form-item-title">Đánh giá:</span>
                                    <div class="prod-rate">
                                        <fieldset class="rating">
                                            <input type="radio" class="rate-poin-rdo" data-point="1" id="star1" name="rating" value="1">
                                            <label class="full" for="star1" title="Thất vọng: cho 1 sao">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                </svg>
                                            </label>
                                            <input type="radio" class="rate-poin-rdo" data-point="2" id="star2" name="rating" value="2">
                                            <label class="full" for="star2" title="Trung bình: cho 2 sao">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                </svg>
                                            </label>
                                            <input type="radio" class="rate-poin-rdo" data-point="3" id="star3" name="rating" value="3">
                                            <label class="full" for="star3" title="Bình thường: cho 3 sao">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                </svg>
                                            </label>
                                            <input type="radio" class="rate-poin-rdo" data-point="4" id="star4" name="rating" value="4">
                                            <label class="full" for="star4" title="Hài lòng: cho 4 sao">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                </svg>
                                            </label>
                                            <input type="radio" class="rate-poin-rdo" data-point="5" id="star5" name="rating" value="5">
                                            <label class="full" for="star5" title="Rất hài lòng: cho 5 sao">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                </svg>
                                            </label>
                                        </fieldset>
                                        <div class="rate-stars">
                                            <input type="hidden" id="rate-record" name="rate-record" value="0">
                                            <input type="text" id="rate-point" name="rate-point" style="position: absolute; left: -2000px" title="Bạn cho sản phẩm này bao nhiêu ★">
                                        </div>
                                    </div>
                                </div>
                                <p class="p-close"><button id="send-comment" class="link-close">Gửi bình luận</button></p>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="rate-reviews" class="box-view-comments">
                    <span class="countcomments">Có {{ $totalCommentsCount }} bình luận:</span>
                    <div id="rate-reviews-list">
                        @if(!empty($sendCmt))
                        @include('cntt.home.partials.cmt', ['sendCmt' => $sendCmt])
                        @endif
                    </div>
                    <div id="comments-list">
                        @include('cntt.home.partials.comment', ['comments' => $comments, 'user' => $user])
                    </div>
                    <nav class="d-flex justify-content-center mt-2 paginate-cmt">
                        {{ $comments->links() }}
                    </nav>
                </div>
            </div>
        </div>

        <!-- Hotline -->
        <div class="col-lg-3 mt-4">
            <div class="support-prod new-prod">
                <div class="bg-prod d-flex align-items-center">
                    <h2><i class="fa-solid fa-users"></i> Thông tin liên hệ</h2>
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
                                <a href="https://zalo.me/{{ $val->zalo }}" title="Chat {{ $val->name }} qua Zalo">
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

<div class="price-modal">
    <!-- Modal -->
    <div class="modal fade" id="priceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yêu cầu nhận giá tốt về sản phẩm <span class="price-code">{{ $product->code }}</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger hide" id="price-error"></div>
                    <div class="form-group mb-2">
                        <label for="name">Họ tên</label>
                        <input type="text" name="name" class="form-control" id="name">
                        <span class="name-price-erros" style="color: red;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" id="phone">
                        <span class="phone-price-errors" style="color: red;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group mb-2">
                        <label for="amount">Số lượng cần mua</label>
                        <input type="number" min="1" class="form-control" name="amount" id="amount">
                    </div>
                    <div class="form-group">
                        <label>Mục đích mua hàng: </label>
                        <label><input value="0" name="purpose" type="radio" style="margin-left: 15px; margin-right: 5px;">Công ty</label>
                        <label><input value="1" name="purpose" type="radio" style="margin-left: 15px; margin-right: 5px;">Dự án</label>
                    </div>
                </div>
                @if (!empty($product))
                <input type="hidden" name="code" id="code" value="{{ $product->code }}">
                <input type="hidden" name="slug" id="slug" value="{{ $product->slug }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @endif
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary send-price">Gửi yêu cầu</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Link to Swiper's JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="{{asset('cntt/js/product.js')}}"></script>
<script type="text/javascript">
    var swiper2 = new Swiper(".mySwiper2", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    // Báo giá
    document.querySelector('.send-price').addEventListener('click', function(e) {
        e.preventDefault();
        let submitButton = this;
        let csrfToken = document.querySelector('.send-price input[name="_token"]').value;

        // Vô hiệu hóa nút submit để ngăn gửi nhiều lần
        submitButton.disabled = true;
        let nameElement = document.getElementById('name');
        let phoneElement = document.getElementById('phone');
        let emailElement = document.getElementById('email');
        let amountElement = document.getElementById('amount');
        let purposeElement = document.querySelector('input[name="purpose"]:checked');
        let codeElement = document.getElementById('code');
        let slugElement = document.getElementById('slug');

        // Kiểm tra xem các phần tử có tồn tại không
        if (!nameElement || !phoneElement) {
            document.getElementById('price-error').innerText = 'Vui lòng điền đầy đủ thông tin!';
            document.getElementById('price-error').classList.remove('hide');
            submitButton.disabled = false; // Kích hoạt lại nút submit
            return;
        }

        let nameValue = nameElement.value.trim();
        let phoneValue = phoneElement.value.trim();

        // Ẩn thông báo trước khi gửi form
        document.getElementById('price-error').classList.add('hide');

        let isValid = true;
        let errorMessages = {};

        // Kiểm tra trường 'name'
        if (nameValue.length < 3 || nameValue.length > 256) {
            isValid = false;
            errorMessages.name = 'Họ tên phải có từ 3 đến 256 ký tự.';
        } else {
            document.querySelector('.name-price-erros').innerText = '';
        }
        if (errorMessages.name) {
            document.querySelector('.name-price-erros').innerText = errorMessages.name;
        }

        // Kiểm tra trường 'phone'
        const phonePattern = /^[0-9]{10,12}$/;
        if (!phonePattern.test(phoneValue)) {
            isValid = false;
            errorMessages.phone = 'Số điện thoại không hợp lệ.';
        } else {
            document.querySelector('.phone-price-errors').innerText = '';
        }
        if (errorMessages.phone) {
            document.querySelector('.phone-price-errors').innerText = errorMessages.phone;
        }

        // Nếu không hợp lệ thì ngừng xử lý và hiển thị lỗi
        if (!isValid) {
            document.getElementById('price-error').innerText = 'Vui lòng kiểm tra lại thông tin của bạn.';
            document.getElementById('price-error').classList.remove('hide');
            submitButton.disabled = false; // Kích hoạt lại nút submit
            return;
        }

        let data = {
            name: nameElement.value,
            phone: phoneElement.value,
            email: emailElement ? emailElement.value : null,
            amount: amountElement ? amountElement.value : null,
            purpose: purposeElement ? purposeElement.value : 0,
            code: codeElement.value,
            slug: slugElement.value,
        };

        fetch('{{ route("price.request") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Đóng modal bằng Bootstrap JavaScript API
                    let modalElement = document.querySelector('#priceModal');
                    let modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    }
                    toastr.success('Yêu cầu báo giá đã được gửi thành công', 'Thành công', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 10000
                    });
                    // Xóa dữ liệu cũ
                    document.getElementById('name').value = '';
                    document.getElementById('phone').value = '';
                    document.getElementById('email').value = '';
                    document.getElementById('amount').value = '';
                    document.querySelectorAll('input[name="purpose"]').forEach(radio => radio.checked = false);
                    document.getElementById('code').value = '';
                    document.getElementById('slug').value = '';
                } else {
                    document.getElementById('price-error').innerText = data.error;
                    document.getElementById('price-error').classList.remove('hide');
                }
                submitButton.disabled = false; // Kích hoạt lại nút submit sau khi xử lý xong
            })
            .catch(error => {
                document.getElementById('price-error').innerText = 'Đã xảy ra lỗi khi gửi yêu cầu.';
                document.getElementById('price-error').classList.remove('hide');
                submitButton.disabled = false; // Kích hoạt lại nút submit nếu xảy ra lỗi
            });
    });

    // Xử lý khi nhấn vào thẻ a
    document.querySelectorAll('.scrollToRateBox').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault(); // Ngăn hành vi mặc định của thẻ a

            // Cuộn đến #rate-box với một khoảng offset
            var rateBox = document.getElementById('rate-box');
            if (rateBox) {
                var offset = -55; // Điều chỉnh khoảng lệch để đảm bảo hiển thị tốt
                var rateBoxPosition = rateBox.getBoundingClientRect().top + window.pageYOffset + offset;

                // Cuộn đến vị trí đã điều chỉnh
                window.scrollTo({
                    top: rateBoxPosition,
                    behavior: 'smooth'
                });
                setTimeout(function() {}, 500); // Thời gian đợi có thể điều chỉnh
            }
        });
    });

    // Chức năng comments
    $(document).ready(function() {
        function bindCommentFormEvents() {
            document.querySelectorAll('.rate-poin-rdo').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    let value = this.value;

                    // Reset fill for all stars
                    document.querySelectorAll('.rating label svg').forEach(function(star) {
                        star.style.fill = '#ddd';
                    });

                    // Fill stars up to the selected one
                    for (let i = 1; i <= value; i++) {
                        document.querySelector('#star' + i + ' ~ label svg').style.fill = '#ffc107';
                    }
                });
            });

            $('.reply-btn').on('click', function(e) {
                e.preventDefault();
                let commentId = $(this).data('comment-id');

                // Kiểm tra phần tử có được tìm thấy không
                let targetForm = $(`.reply-form[data-comment-id="${commentId}"]`);
                // Kiểm tra nếu form đang ẩn, thì hiển thị và ẩn tất cả các form khác
                if (targetForm.is(':hidden')) {
                    $('.reply-form').hide(); // Ẩn tất cả các form khác
                    targetForm.show(); // Hiển thị form tương ứng với comment ID
                } else {
                    // Nếu form đang hiển thị, thì ẩn nó đi
                    targetForm.hide();
                }
            });

            // Xử lý khi nhấn nút close-cmt
            $('.close-cmt').on('click', function() {
                // Tìm form reply gần nhất và ẩn nó
                $(this).closest('.reply-form').hide();
            });

            // Khi nhấn nút gửi bình luận trong form trả lời
            $(document).on('click', '.submit-reply', function(e) {
                e.preventDefault();
                var isValid = true;

                // Lấy form hiện tại
                var form = $(this).closest('form');

                // Lấy giá trị của các trường trong form hiện tại
                var replyCmtContent = form.find('.reply-cmt-content').val().trim();
                var replyCmtName = form.find('.reply-cmt-name').val().trim();
                var replyCmtEmail = form.find('.reply-cmt-email').val().trim();

                // Xóa các thông báo lỗi cũ
                form.find('.rpl-name-err').text('');
                form.find('.rpl-email-err').text('');
                form.find('.rpl-content-err').text('');
                form.find('.reply-cmt-content').css('border-color', '');
                form.find('.reply-cmt-name').css('border-color', '');
                form.find('.reply-cmt-email').css('border-color', '');

                // Kiểm tra trường reply-cmt-content
                if (replyCmtContent === '') {
                    form.find('.rpl-content-err').text('Nội dung bình luận / nhận xét không được để trống.');
                    form.find('.reply-cmt-content').css('border-color', 'red').focus();
                    isValid = false;
                }

                // Kiểm tra trường reply-cmt-name
                if (replyCmtName === '') {
                    form.find('.rpl-name-err').text('Họ và tên không được để trống.');
                    form.find('.reply-cmt-name').css('border-color', 'red').focus();
                    isValid = false;
                }

                // Kiểm tra trường reply-cmt-email
                if (replyCmtEmail === '') {
                    form.find('.rpl-email-err').text('Email không được để trống.');
                    form.find('.reply-cmt-email').css('border-color', 'red').focus();
                    isValid = false;
                } else if (!validateEmail(replyCmtEmail)) {
                    form.find('.rpl-email-err').text('Email không đúng định dạng.');
                    form.find('.reply-cmt-email').css('border-color', 'red').focus();
                    isValid = false;
                }

                // Nếu không có lỗi, gọi AJAX để lưu bình luận
                if (isValid) {
                    $.ajax({
                        url: '{{ route("cmt.replyCmt") }}', // Sử dụng URL từ Laravel route
                        method: 'POST',
                        data: {
                            product_id: $('#idprd').val(),
                            slugProduct: $('#slugPrd').val(),
                            user_id: $('#idUser').val(),
                            parent_id: form.find('#reply-cmt-parent').val(),
                            content: replyCmtContent,
                            name: replyCmtName,
                            email: replyCmtEmail,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                // Xóa các giá trị của form sau khi gửi thành công
                                form.find('.reply-cmt-content').val('');
                                form.find('.reply-cmt-name').val('');
                                form.find('.reply-cmt-email').val('');
                                form.find('#reply-cmt-parent').val('');

                                // Chèn phần bình luận trả lời ngay phía dưới form trả lời
                                form.after(response.comment_html);

                                // Cập nhật số lượng bình luận
                                var countElement = $('.countcomments');
                                var currentCount = parseInt(countElement.text().match(/\d+/)[0]); // Lấy số lượng bình luận hiện tại
                                countElement.text('Có ' + (currentCount + 1) + ' bình luận:'); // Cập nhật số lượng bình luận
                                form.hide(); // Ẩn form đã gửi thành công
                                toastr.success('Cập nhật thành công! Vui lòng đợi phản hồi từ Admin', 'Thành công', {
                                    progressBar: true,
                                    closeButton: true,
                                    timeOut: 10000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error('Đã xảy ra lỗi khi gửi bình luận.', 'Lỗi', {
                                progressBar: true,
                                closeButton: true,
                                timeOut: 5000
                            });
                        }
                    });
                }
            });

            // Hàm kiểm tra định dạng email
            function validateEmail(email) {
                var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            $('#send-comment').on('click', function(event) {
                event.preventDefault(); // Ngăn chặn form submit

                var isValid = true;

                // Lấy giá trị của các trường
                var cmtContent = $('#comment-content').val().trim();
                var cmtName = $('#comment-name').val().trim();
                var cmtEmail = $('#comment-email').val().trim();
                var cmtRate = $('input[name="rating"]:checked').val();

                // Xóa các thông báo lỗi cũ
                $('#name-error').text('');
                $('#email-error').text('');
                $('#content-error').text('');
                $('#comment-content').css('border-color', '');
                $('#comment-name').css('border-color', '');
                $('#comment-email').css('border-color', '');

                // Kiểm tra trường comment-content
                if (cmtContent === '') {
                    $('#content-error').text('Nội dung bình luận / nhận xét không được để trống.');
                    $('#comment-content').css('border-color', 'red').focus();
                    isValid = false;
                }

                // Kiểm tra trường comment-name
                if (cmtName === '') {
                    $('#name-error').text('Họ và tên không được để trống.');
                    $('#comment-name').css('border-color', 'red').focus();
                    isValid = false;
                }

                // Kiểm tra trường comment-email
                if (cmtEmail === '') {
                    $('#email-error').text('Email không được để trống.');
                    $('#comment-email').css('border-color', 'red').focus();
                    isValid = false;
                } else if (!validateEmail(cmtEmail)) {
                    $('#email-error').text('Email không đúng định dạng.');
                    $('#comment-email').css('border-color', 'red').focus();
                    isValid = false;
                }

                $('#review-info').show();
                // Nếu không có lỗi, gọi AJAX để lưu bình luận
                if (isValid) {
                    // Disable nút gửi để ngăn chặn việc nhấn nhiều lần
                    $('#send-comment').prop('disabled', true);
                    $.ajax({
                        url: '{{ route("comments.sendCmt") }}', // Sử dụng URL từ Laravel route
                        method: 'POST',
                        data: {
                            product_id: $('#idprd').val(),
                            slugProduct: $('#slugPrd').val(),
                            user_id: $('#idUser').val(),
                            parent_id: 0,
                            content: cmtContent,
                            name: cmtName,
                            email: cmtEmail,
                            star: cmtRate,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                // Xóa các giá trị của form sau khi gửi thành công
                                $('#rate-reviews-list').prepend(response.comment_html);

                                // Cập nhật số lượng bình luận
                                var countElement = $('.countcomments');
                                var currentCount = parseInt(countElement.text().match(/\d+/)[0]); // Lấy số lượng bình luận hiện tại
                                countElement.text('Có ' + (currentCount + 1) + ' bình luận:'); // Cập nhật số lượng bình luận

                                $('#rate-form')[0].reset();
                                $('#review-info').hide();
                                $('#send-comment').prop('disabled', false);
                                toastr.success('Cập nhật thành công! Vui lòng đợi phản hồi từ Admin', 'Thành công', {
                                    progressBar: true,
                                    closeButton: true,
                                    timeOut: 10000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error('Đã xảy ra lỗi khi gửi bình luận.', 'Lỗi', {
                                progressBar: true,
                                closeButton: true,
                                timeOut: 5000
                            });
                            $('#send-comment').prop('disabled', false);
                        }
                    });
                }
            });
        }
        // Phân trang bình luận
        function addPaginationListeners() {
            const paginationLinks = document.querySelectorAll('.paginate-cmt a');

            paginationLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.href;

                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('app').innerHTML = html;
                            // Cuộn đến rate-reviews với một khoảng offset
                            var commentBox = document.getElementById('rate-reviews');
                            var offset = -50; // Điều chỉnh khoảng lệch để đảm bảo hiển thị tốt
                            var commentBoxPosition = commentBox.getBoundingClientRect().top + window.pageYOffset + offset;

                            // Cuộn đến vị trí đã điều chỉnh
                            window.scrollTo({
                                top: commentBoxPosition,
                                behavior: 'smooth'
                            });
                            addPaginationListeners(); // Gọi lại hàm này sau khi tải nội dung mới
                            bindCommentFormEvents();
                        })
                        .catch(error => console.error('Error loading page:', error));
                });
            });
        }
        // Gọi các sự kiện ban đầu
        addPaginationListeners();
        bindCommentFormEvents(); // Lắng nghe sự kiện cho form bình luận
    });

    let typingTimer; // Biến để lưu trữ thời gian chờ
    const typingDelay = 1000; // Đặt thời gian chờ là 3 giây

    function fetchProducts() {
        clearTimeout(typingTimer); // Xóa bộ đếm thời gian cũ khi người dùng nhập lại

        // Bắt đầu bộ đếm mới chỉ sau khi người dùng ngừng nhập 3 giây
        typingTimer = setTimeout(function() {
            let searchText = $('#searchSggCP').val();
            let productId = $('#productId').val();
            let slugPro = $('#slugPro').val();

            // Kiểm tra nếu không có giá trị nhập hoặc độ dài nhỏ hơn 1 ký tự
            if (searchText.trim().length < 1) {
                $('#compareResults').html(''); // Xóa kết quả nếu không có từ khóa tìm kiếm
                return;
            }

            $.ajax({
                url: '{{ route("home.compareProduct") }}', // Đường dẫn tới API tìm kiếm sản phẩm
                method: 'GET',
                data: {
                    query: searchText,
                    id: productId
                },
                success: function(response) {
                    let results = '';

                    // Nếu có dữ liệu trả về
                    if (response.length > 0) {
                        response.forEach(function(product) {
                            results += `<div class="compare-outer">
                                        <div class="compare-row">
                                            <div class="compare-title">
                                                <a href="so-sanh-${slugPro}-vs-${product.slug}">
                                                    <strong style="color:#ff0000;">${product.code}</strong> ${product.name}
                                                </a>
                                            </div>
                                        </div>
                                    </div>`;
                        });
                    } else {
                        results = `<div class="compare-outer">
                                    <div class="compare-row">
                                        <div class="compare-title">
                                            Không tìm thấy sản phẩm 
                                        </div>
                                    </div>
                                </div>`;
                    }
                    // Hiển thị kết quả tìm kiếm
                    $('#compareResults').html(results).show();
                },
                error: function() {
                    $('#compareResults').html('<div class="search-item">Lỗi khi tìm kiếm sản phẩm</div>');
                }
            });
        }, typingDelay); // Thời gian chờ 3 giây
    }

    // Gán sự kiện vào input
    $('#searchSggCP').on('keyup', fetchProducts);


    // Lấy phần tử modal và nút pop-gallery
    const modal = document.getElementById("imageModal");
    const popGalleryButton = document.querySelector(".pop-gallery");

    // Khi nhấn vào nút pop-gallery, mở modal
    popGalleryButton.addEventListener("click", function(event) {
        event.preventDefault(); // Ngăn chặn việc chuyển trang nếu là link
        modal.style.display = "block"; // Hiển thị modal
    });
</script>
@endsection