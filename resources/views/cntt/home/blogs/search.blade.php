@extends('cntt.layouts.app')

@section('content')
<div class="pt-44" id="breadcrumb">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item">Kết quả tìm kiếm: @if(!empty($nameCate)) <strong>{{$nameCate}}</strong>@else <strong>Bài viết</strong> @endif @if(!empty($keyword)) -- <strong>{{ $keyword }}</strong> @else -- <strong>tất cả</strong> @endif</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container">
    <div class="row">
    <h2 class="text-center search-h2 mt-3">Tìm thấy <strong>{{ $total }}</strong> bài viết cho từ khoá <strong>@if(!empty($nameCate)) {{$nameCate}}</strong>@else <strong>Bài viết</strong> @endif @if(!empty($keyword)) -- <strong>{{ $keyword }}</strong> @else -- <strong>tất cả</strong> @endif</h2>
    </div>
    <div class="row mt-3 res-w100 custom-row" id="product-data">
        @include('cntt.home.blogs.partials.search', ['news' => $news])
    </div>
    <nav class="d-flex justify-content-center">
        {{ $news->links() }}
    </nav>
</div>
@endsection

@section('css')
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