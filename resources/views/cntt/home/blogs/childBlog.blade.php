@section('css')
<link rel="stylesheet" href="{{ asset('cntt/css/blog.css') }}">
@endsection

@extends('cntt.layouts.app')
@section('content')
<div class="pt-44">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ asset('/blogs') }}">Blogs</a></li>
                @foreach ($allParents as $parent)
                    <li class="breadcrumb-item"><a href="{{ asset('/blogs/' . $parent->slug) }}">{{ $parent->name }}</a></li>
                @endforeach
                <li class="breadcrumb-item">{{ $titleCate->name }}</li>
            </ol>
        </nav>
    </div>
</div>
<section id="news-list">
    <div class="container">
        <div class="row mt-3 mb-3">
            <div class="col-lg-8">
                <div class="collection-title-news">
                    <h1>
                        {{ $titleCate->name }}
                    </h1>
                </div>
                @foreach($news as $item)
                <div class="row list-news mb-3">
                    <div class="col-md-5">
                        <div class="media-left">
                            <a href="{{ asset('blogs/'.$item->slug) }}">
                                <img loading="lazy" width="320" height="190" src="{{ asset(str_replace('bai-viet/', 'bai-viet/medium/', $item->image)) }}" data-src="{{ asset(str_replace('bai-viet/', 'bai-viet/medium/', $item->image)) }}" srcset="{{ asset(str_replace('bai-viet/', 'bai-viet/medium/', $item->image)) }}" alt="{{ $item->alt_img }}" title="{{ $item->title_img }}">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-7 padding-left-0">
                        <div class="media-body">
                            <a href="{{ asset('blogs/'.$item->slug) }}">{{ $item->name }}</a>
                            <div class="author_meta">
			                    <span class="entry-date">{{ $item->created_at->format('F d, Y') }}</span>
                                <span class="meta-sep">by</span>
                                <span class="author vcard">
                                    @if(!empty($item->user))
                                    <a class="url fn n" href="{{ asset('/blogs/author/' . $item->user->slug) }}" title="Author {{ $item->user->name }}">{{ $item->user->name }}</a>
                                    @else Unknown
                                    @endif
                                </span>
                                @if(!empty($item->view_count))
                                <span class="view-count"><i class="fa-solid fa-eye"></i> {{ $item->view_count }}</span>
                                @endif
                            </div>
                            <span class="media-desc">{{ $item->desc }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-4">
                <!--  -->
                <div class="head-blog mb-3">
                    <span>Chuyên mục chính</span>
                </div>
                <ul class="news_cate_hot">
                    @foreach($cateMenu as $val)
                    <li>
                        <a href="{{ asset('blogs/'.$val->slug) }}">✓ {{ $val->name }}</a>
                    </li>
                    @endforeach
                </ul>
                <!-- Bài viết xem nhiều nhất -->
                @if(!$viewer->isEmpty())
                <div class="head-blog bgeee mb-3">
                    <span>Bài viết Xem nhiều nhất</span>
                </div>
                <ul class="most-view">
                    @foreach($viewer as $item)
                    <li>
                        <a title="{{ $item->title }}" href="{{ asset('blogs/'.$item->slug) }}">{{ $item->name }}</a>
                    </li>
                    @endforeach
                </ul>
                @endif
                <!-- Bài viết nổi bật -->
                @if(!$outstand->isEmpty())
                <div class="head-blog bgeee mb-3">
                    <span>Bài viết nổi bật</span>
                </div>
                <div class="hot-news">
                    @foreach($outstand as $val)
                    <div class="media">
                        <div class="media-left img-border">
                            <a href="{{ asset('blogs/'.$val->slug) }}">
                                <img loading="lazy" width="146" height="99" src="{{ asset(str_replace('bai-viet/', 'bai-viet/small/', $val->image)) }}" data-src="{{ asset(str_replace('bai-viet/', 'bai-viet/small/', $val->image)) }}" srcset="{{ asset(str_replace('bai-viet/', 'bai-viet/small/', $val->image)) }}" alt="{{ $val->alt_img }}" title="{{ $val->title_img }}">
                            </a>
                        </div>
                        <div class="media-right">
                            <a href="{{ asset('blogs/'.$val->slug) }}">{{ $val->name }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                <!-- Sản phẩm liên quan -->
                @if(!empty($relatedPro))
                <div class="head-blog bgeee mb-3">
                    <span>Sản phẩm liên quan</span>
                </div>
                <div class="related-products">
                    @foreach($relatedPro as $value)
                    <div class="media-products">
                        <div class="media-left img-border">
                            <a href="{{ asset('/'.$value->slug) }}">
                                @if($value->main_image)
                                <img class="thumb ls-is-cached lazyloaded" data-src="{{ asset($value->main_image->image) }}"
                                    alt="{{ $value->main_image->alt }}" title="{{ $value->main_image->title }}" src="{{ asset($value->main_image->image) }}">
                                @else
                                <img class="thumb ls-is-cached lazyloaded"
                                    data-src="{{ asset('storage/images/image-coming-soon.jpg') }}" alt="Image Coming Soon" title="Image Coming Soon"
                                    src="{{ asset('storage/images/image-coming-soon.jpg') }}">
                                @endif
                            </a>
                        </div>
                        <div class="media-right">
                            <a href="{{ asset('/'.$value->slug) }}">{{ $value->name }}</a>
                            <span class="new-price">Liên hệ</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection