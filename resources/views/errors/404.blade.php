<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERROR 404</title>

    <link rel="apple-touch-icon" href="{{ asset($globalSetting->image) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($globalSetting->image) }}">

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
    @yield('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.dn-prd-cate, .dn-main-cate').hover(
                function () {
                    $('.dn-main-cate').css('display', 'block');
                },
                function () {
                    // Khi chuột rời khỏi cả hai
                    setTimeout(() => {
                        if (!$('.dn-prd-cate:hover').length && !$('.dn-main-cate:hover').length) {
                            $('.dn-main-cate').css('display', 'none');
                        }
                    }, 100); // Thêm một khoảng delay để tránh nhấp nháy
                }
            );
        });
    </script>
    <!-- End Script -->
</body>

</html>