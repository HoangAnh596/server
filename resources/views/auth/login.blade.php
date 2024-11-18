@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Xin chào tới trang quản trị!</h1>
                                </div>
                                @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                                @endif
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="exampleInputEmail" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Nhập địa chỉ email..." name="email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Mật khẩu" name="password">
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck" name="remember">
                                            <label class="custom-control-label" for="customCheck">Lưu tài khoản</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block" type="submit"> Đăng nhập </button>
                                    <hr>
                                    <button class="btn btn-google btn-user btn-block" type="reset"><i class="fab fa-google fa-fw"></i> Đăng nhập bằng Google </button>
                                </form>
                                <div class="text-center mt-2">
                                    <a class="small" href="{{ route('password.request') }}">Quên mật khẩu?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('register') }}">Tạo tài khoản mới!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection