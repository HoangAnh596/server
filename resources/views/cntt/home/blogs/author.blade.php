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
                <li class="breadcrumb-item">Author</li>
            </ol>
        </nav>
    </div>
</div>
<section id="news-list">
    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-8">
                @foreach($users as $index => $user)
                <div class="row author-header {{ $loop->index % 2 == 0 ? '' : 'bg-white' }}">
                    <div class="d-flex align-items-center justify-content-center col-lg-2 col-md-3 col-sm-3 col-xs-4 padding-img">
                        <a href="{{ asset('/blogs/author/' . $user->slug) }}" title="Author {{ $user->name }}">
                            <img loading="lazy" width="139" height="139" src="{{ asset($user->image) }}" data-src="{{ asset($user->image) }}" srcset="{{ asset($user->image) }}" alt="{{ $user->alt_img }}">
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
                @endforeach
                <nav class="float-right">
                    {{ $users->links() }}
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
            </div>
        </div>
    </div>
</section>

@endsection