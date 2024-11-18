@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Thêm mới Slider</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Slider</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="slidersForm" action="{{ route('sliders.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('sliders.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                </div>
            </div>
            <div class="text-dark card-body border-top">
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tên Slider :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            <span id="name-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tiêu đề :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-8">
                        <textarea name="title" class="form-control" rows="3" style="width: 100%;">{{ old('title') }}</textarea>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Mô tả chi tiết :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-8">
                        <textarea name="description" class="form-control" rows="4" style="width: 100%;">{{ old('description') }}</textarea>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4 d-flex flex-row-reverse align-items-center" style="height: 38px;">Url :<div class="warningMenu">*</div>
                            </div>
                            <div class="col-7">
                                <div class="form-group">
                                    <input type="text" name="url" id="name" class="form-control" value="{{ old('url') }}">
                                </div>
                            </div>
                            <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tên Url :<div class="warningMenu">*</div>
                            </div>
                            <div class="col-7">
                                <div class="form-group">
                                    <input type="text" name="url_text" id="name" class="form-control" value="{{ old('url_text') }}">
                                </div>
                            </div>
                            <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Ảnh slider:<div class="warningMenu">*</div>
                    </div>
                    <div class="col-2">
                        <div class="input-group">
                            <input id="thumbnail" class="form-control" type="hidden" name="filepath">
                            <span class="input-group-btn">
                                <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                                    <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                                </button>
                            </span>
                        </div>
                        <div id="holder"><img src="{{ old('filepath') }}"></div>
                    </div>
                    <div class="col-3 d-flex flex-row align-items-center" style="height: 38px;">(Kích thước đề nghị 636 x 334 px) <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Màu nền Slider :</div>
                    <div class="col-2 d-flex align-items-center">
                        <select class="form-control" aria-label="Default" name="is_color">
                            <option value="0">Đen (black)</option>
                            <option value="1">Xám (#efefef)</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red; margin-left: 38px;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Hiển thị :</div>
                    <div class="col-2 d-flex align-items-center">
                        <select class="form-control" aria-label="Default" name="is_public">
                            <option value="0">Không</option>
                            <option value="1">Có</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Thứ tự hiển thị :</div>
                    <div class="col-1">
                        <input type="number" class="form-control" style="width:80px" name="stt_slider">
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>

            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </form>
    </div>
</div>

@endsection

<!-- @section('js')
<script>
$(document).ready(function() {
    var timer;
    var isPhoneValid = false; // Biến để kiểm tra tính hợp lệ của số điện thoại

    function validatePhone(phone) {
        // Biểu thức chính quy để kiểm tra số điện thoại Việt Nam và chấp nhận khoảng trắng
        var phoneRegex = /^(0[1-9])+(\s?[0-9]){8,9}$/;
        return phoneRegex.test(phone);
    }

    $('#phone').on('blur', function() {
        var phoneInput = $(this).val().trim();
        var errorMessage = $('#phone-error');

        // Xóa bộ đếm thời gian nếu người dùng nhấp vào lại trước khi hết 5 giây
        if (timer) {
            clearTimeout(timer);
        }

        // Thiết lập bộ đếm thời gian để thực hiện kiểm tra sau 5 giây
        timer = setTimeout(function() {
            if (validatePhone(phoneInput)) {
                errorMessage.hide();
                isPhoneValid = true; // Số điện thoại hợp lệ
            } else {
                errorMessage.show();
                isPhoneValid = false; // Số điện thoại không hợp lệ
            }
        }, 2000); // 2000ms tương đương với 2 giây
    });

    $('#slidersForm').on('submit', function(e) {
        var phoneInput = $('#phone').val().trim();
        var errorMessage = $('#phone-error');

        // Kiểm tra tính hợp lệ của số điện thoại khi submit form
        if (!validatePhone(phoneInput)) {
            e.preventDefault(); // Ngăn chặn form gửi đi
            errorMessage.show();
            isPhoneValid = false; // Số điện thoại không hợp lệ
        } else {
            errorMessage.hide();
            isPhoneValid = true; // Số điện thoại hợp lệ
        }
    });
});
</script>
@endsection -->