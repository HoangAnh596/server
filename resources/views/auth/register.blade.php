@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Tạo mới tài khoản!</h1>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <!-- <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="Tên tài khoản" name="name" value="{{ old('name') }}">         
                            </div> -->
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Địa chỉ email" name="email" value="{{ old('email') }}" >
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Mật khẩu" name="password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Xác nhận mật khẩu" name="password_confirmation">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block"> Đăng ký tài khoản </button>
                            <hr>
                            <a href="#" class="btn btn-google btn-user btn-block"> <i class="fab fa-google fa-fw"></i> Đăng ký tài khoản với Google</a>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('password.request') }}">Quên mật khẩu?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{ route('login') }}">Đăng nhập!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection