<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/images/setting/favicon-admin.png') }}">
    <title>{{ config('app.name', 'Trang quản trị') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.0.0/css/sb-admin-2.min.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('cntt/css/admin.css')}}">
    <!-- link css tinymce -->
    <base href="{{asset('/')}}">
    @yield('css')
</head>

<body>
    <div id="app">
        @include('components.header')
        <main class="">
            <!-- @include('components.message') -->
            @yield('content')
        </main>
        @include('components.footer')
    </div>

    <!-- Start Script -->
    <script src="{{asset('cntt/js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{asset('cntt/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('cntt/js/templatemo.js')}}"></script>
    <script src="{{asset('cntt/js/custom.js')}}"></script>
    <script src="{{asset('cntt/js/admin.js')}}"></script>
    <script src="{{asset('cntt/js/slick.min.js')}}"></script>
    
    <!-- select2 -->
    
    <!-- tagsinput -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <!--  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @if (Session::has('message'))
    <script>
        toastr.options = {
            "progressBar": true,
            "closeButton": true,
            "timeOut": 12000
        };
        toastr.success("{{ addslashes(Session::get('message')) }}", 'Success!');
    </script>
    @endif

    <?php if ($errors->any()): ?>
    <script>
        toastr.options = {
            "progressBar": true,
            "closeButton": true,
            "timeOut": 12000
        };
        <?php foreach ($errors->all() as $error): ?>
            toastr.error("<?php echo addslashes($error); ?>", 'Error!');
        <?php endforeach; ?>
    </script>
    <?php endif; ?>
    @yield('js')
    <!-- End Script -->
</body>

</html>