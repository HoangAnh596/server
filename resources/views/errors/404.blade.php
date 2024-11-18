<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERROR 404</title>

    <link rel="stylesheet" href="{{asset('cntt/css/templatemo.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/slick.min.css')}}">
    <link rel="apple-touch-icon" href="{{ asset($globalSetting->image) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($globalSetting->image) }}">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="{{asset('cntt/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/home.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/footer.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/errors.css')}}">
    @yield('css')
</head>

<body>
    <div id="app">
        @include('cntt.components.header')
        <main>
            <div class="container">
                <div class="hp-error">
                    <h1 class="title text-center">Xin lỗi, chúng tôi không tìm thấy trang mà bạn cần!</h1>
                    <div class="img-404">
                        <img src="{{ asset('cntt/img/web-404-robot-ud.png') }}" alt="404" title="404">
                    </div>
                    <div class="list-contact">
                        <div class="itemct">
                            <p class="text-center">Trở về trang chủ<br>Nvidia</p>
                            <a href="/" class="link link--yellow">
                                Nvidia
                            </a>
                        </div>
                        <div class="itemct">
                            <p class="text-center">Gọi hỗ trợ<br>(8h00 - 21h30)</p>
                            <a href="tel:1900232460" class="link link--yellow link-tel">1900 123 456</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include('cntt.components.footer')
    </div>

    <!-- Start Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{asset('cntt/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('cntt/js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{asset('cntt/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('cntt/js/templatemo.js')}}"></script>
   <script src="{{asset('cntt/js/custom.js')}}"></script>
    <script src="{{asset('cntt/js/slick.min.js')}}"></script>
    @yield('js')
    <!-- End Script -->
</body>

</html>