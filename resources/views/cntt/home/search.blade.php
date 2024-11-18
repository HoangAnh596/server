@extends('cntt.layouts.app')

@section('content')
<div class="pt-44" id="breadcrumb">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item">Kết quả tìm kiếm: @if(!empty($nameCate)) <strong>{{$nameCate}}</strong>@else <strong>Sản phẩm</strong> @endif @if(!empty($keyword)) -- <strong>{{ $keyword }}</strong> @else -- <strong>tất cả</strong> @endif</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container">
    <div class="row">
        <h2 class="text-center search-h2 mt-4">Tìm thấy <strong>{{ $total }}</strong> sản phẩm cho từ khoá <strong>@if(!empty($nameCate)) {{$nameCate}}</strong>@else <strong>Sản phẩm</strong> @endif @if(!empty($keyword)) -- <strong>{{ $keyword }}</strong> @else -- <strong>tất cả</strong> @endif</h2>
    </div>
    <div class="row">
        <div class="col-md-9 mt-4 res-w100">
            <div class="row custom-row" id="product-data">
                @include('cntt.home.partials.search', ['products' => $products])
            </div>
            <nav class="d-flex justify-content-center mt-3">
                {{ $products->appends(request()->query())->links() }}
            </nav>
        </div>
        <div class="col-md-3 mt-4 res-dnone">
            <!-- Hotline -->
            <div class="support-prod src-fixed mb-4 mb-custom">
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
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('cntt/css/catePro.css')}}">
<style>
    .search-h2 {
        font-size: 1rem;
        margin: 0;
    }
    .src-fixed {
        position: sticky;
        top: 56px;
        left: 0;
        width: 100%;
        z-index: 999;
    }
</style>
@endsection