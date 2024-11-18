<!DOCTYPE html>
<html lang="vi">

<head>
    <title>{{ $titleSeo }}</title>
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    <meta name="robots" content="noindex, nofollow">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="{{ $canonical_url ?? url()->full() }}">
    <meta name="theme-color" content="#76b900">
    <meta name="keywords" content="{{ $keywordSeo }}">
    <meta name="description" content="{{ $descriptionSeo }}">
    <meta property="og:url" content="{{ $canonical_url ?? url()->full() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $titleSeo }}">
    <meta property="og:description" content="{{ $descriptionSeo }}">
    <meta property="og:image" content="{{ asset($globalSetting->image) }}">
    <meta name="author" content="nvidiavn.vn">

    <link rel="apple-touch-icon" href="{{ asset($globalSetting->image) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($globalSetting->image) }}">
    <!-- Thẻ tiếp thị -->
    @if(isset($globalHeaderTags))
        @foreach($globalHeaderTags as $tag)
            {!! $tag->content !!}
        @endforeach
    @endif
    <link rel="stylesheet" href="{{asset('cntt/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/home.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/footer.css')}}">
    
    @yield('css')

</head>

<body>
    <div id="app">
        @include('cntt.components.header')
        @yield('content')
        @include('cntt.components.contact-icon')
        @include('cntt.components.footer')
    </div>

    <!-- Start Script -->
    <script src="{{asset('cntt/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('cntt/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('cntt/js/homepage.js')}}"></script>
    @yield('js')
    <!-- End Script -->

</body>

</html>
