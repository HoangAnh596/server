@section('css')
<link rel="stylesheet" href="{{ asset('cntt/css/blog.css') }}">
@endsection

@extends('cntt.layouts.app')
@section('content')
<div class="bgeee">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ asset('/blogs') }}">Blogs</a></li>
                <li class="breadcrumb-item"><a href="{{ asset('/blogs/author') }}">Author</a></li>
                <li class="breadcrumb-item">{{ $user->name }}</li>
            </ol>
        </nav>
    </div>
</div>
<section id="news-list">
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-8 bl-auth">
                <div class="author-header">
                    <div class="row">
                        <div class="d-flex align-items-center justify-content-center col-lg-2 col-md-3 col-sm-3 col-xs-4 padding-img">
                            <a href="{{ asset('/blogs/author/' . $user->slug) }}" title="Author {{ $user->name }}">
                                <img loading="lazy" width="134" height="134" src="{{ asset($user->image) }}" data-src="{{ asset($user->image) }}" srcset="{{ asset($user->image) }}" alt="{{ $user->alt_img }}">
                            </a>
                        </div>
                        <div class="col-lg-10 col-md-9 col-sm-9 col-xs-8">
                            <div class="row mb-3">
                                <div class="col-sm-6 d-flex align-items-center">
                                    <h1>{{ $user->name }}</h1>
                                </div>
                                <div class="col-sm-6 d-flex align-items-center justify-content-end">
                                    <ul class="author-social">
                                        @if(!empty($user->facebook))
                                        <li>
                                            <a href="{{ asset($user->facebook) }}" target="_blank" rel="nofollow"><i class="fa-brands fa-facebook"></i></a>
                                        </li>
                                        @endif
                                        @if(!empty($user->twitter))
                                        <li>
                                            <a href="{{ asset($user->twitter) }}" target="_blank" rel="nofollow"><i class="fa-brands fa-twitter"></i></a>
                                        </li>
                                        @endif
                                        @if(!empty($user->instagram))
                                        <li>
                                            <a href="{{ asset($user->instagram) }}" target="_blank" rel="nofollow"><i class="fa-brands fa-instagram"></i></a>
                                        </li>
                                        @endif
                                        @if(!empty($user->skype))
                                        <li>
                                            <a href="{{ asset($user->skype) }}" target="_blank" rel="nofollow"><i class="fa-brands fa-skype"></i></a>
                                        </li>
                                        @endif
                                        @if(!empty($user->linkedin))
                                        <li>
                                            <a href="{{ asset($user->linkedin) }}" target="_blank" rel="nofollow"><i class="fa-brands fa-linkedin"></i></a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            @if(!empty($user->content))
                            <p>{!! $user->content !!}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @foreach($newAll as $item)
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
                                @if(!empty($item->view_count))
                                <span class="view-count"><i class="fa-solid fa-eye"></i> {{ $item->view_count }}</span>
                                @endif
                            </div>
                            <span class="media-desc">{{ $item->desc }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                <nav class="float-right">
                    {{ $newAll->links() }}
                </nav>
            </div>
            <div class="col-lg-4">
                <!-- Chuyên mục chính -->
                <div class="head-blog bgeee mb-3">
                    <span>Chuyên mục chính</span>
                </div>
                <ul class="news_cate_hot">
                    @foreach($cateMenu as $val)
                    <li>
                        <a href="{{ asset('blogs/'.$val->slug) }}"><span style="font-weight: bold;">✓</span> {{ $val->name }}</a>
                    </li>
                    @endforeach
                </ul>

                @if(!$viewer->isEmpty())
                <!-- Bài viết xem nhiều nhất -->
                <div class="head-blog bgeee mb-3">
                    <span>Bài viết Xem nhiều nhất</span>
                </div>
                <ul class="most-view">
                    @foreach($viewer as $item)
                    <li>
                        <a href="{{ asset('blogs/'.$item->slug) }}">{{ $item->name }}</a>
                    </li>
                    @endforeach
                </ul>
                @endif

                @if(!$outstand->isEmpty())
                <!-- Bài viết nổi bật -->
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
            </div>
        </div>
    </div>
</section>

@endsection