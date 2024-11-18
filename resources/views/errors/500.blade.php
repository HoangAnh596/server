<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERROR 500</title>
    <link rel="stylesheet" href="{{asset('cntt/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/errors.css')}}">
    @yield('css')
</head>

<body>
    <div id="app">
        <main>
            <div class="container">
                <div class="hp-error c-500">
                    <h1 class="title text-center">TỪ CHỐI TRUY CẬP</h1>
                    <p class="text-center">Yêu cầu truy cập của bạn nvidia.vn đã bị từ chối.</p>
                    
                    <div class="img-404 mt-5">
                        <img src="{{ asset('cntt/img/web-404-robot-ud.png') }}" alt="500" title="500">
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>