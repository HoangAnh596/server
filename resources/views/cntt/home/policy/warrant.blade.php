@extends('cntt.layouts.app')
@section('content')
<div class="container">
    <div class="pt-44" id="breadcrumb">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                    <li class="breadcrumb-item">{{ $results->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row policy-web mt-2">
        <div class="col-md-3 menu-policy">
            <ul>
                @foreach($cateFooter as $val)
                <li class="{{ $results->url == $val->url ? 'active' : '' }}"><a @if($val->is_click == 1) href="{{ asset($val->url) }}" @else href="javascript:void(0)" @endif>{{ $val->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-9 mt-2">
            <h2>{{ $results->title }}</h2>
            <div class="mt-3" id="chi-tiet">{!! $results->content !!}</div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('cntt/css/support-policy.css')}}">
@endsection