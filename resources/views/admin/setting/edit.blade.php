@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Cấu hình website</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Setting</a></li>
                <li class="breadcrumb-item active">Cập nhật</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form action="{{ route('setting.update', $setting->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @if (!empty($setting))
            <input type="hidden" name="id" value="{{ $setting->id }}">
            @endif
            <div class="text-dark card-body border-top">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info-tab" type="button" role="tab">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                            Cấu hình SEO
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#social-tab" type="button" role="tab">
                            <i class="fa-solid fa-square-share-nodes"></i>
                            Cấu hình mạng xã hội
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#wallet-tab" type="button" role="tab">
                            <i class="fa-solid fa-gear"></i>
                            Cấu hình website
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="info-tab" role="tabpanel">
                        @include("admin.setting.shared.edit-seo")
                    </div>
                    <div class="tab-pane fade" id="social-tab" role="tabpanel">
                        @include("admin.setting.shared.edit-social")
                    </div>
                    <div class="tab-pane fade" id="wallet-tab" role="tabpanel">
                        @include("admin.setting.shared.edit-setting")
                    </div>
                </div>

            </div>
            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm " type="submit" id="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
    let timeout = null;

    // Validate cấu hình SEO
    function delayedValidate(fieldId, warningId, minLength, maxLength) {
        clearTimeout(timeout); // Xóa timeout cũ nếu có, để đặt lại thời gian chờ

        // Đặt một timeout mới, sẽ thực thi sau 2 giây (2000ms)
        timeout = setTimeout(function() {
            validateLength(fieldId, warningId, minLength, maxLength);
        }, 2000);
    }

    function validateLength(fieldId, warningId, minLength, maxLength) {
        const fieldValue = document.getElementById(fieldId).value;
        const warning = document.getElementById(warningId);
        const fieldLength = fieldValue.length;

        if (fieldLength >= minLength && fieldLength <= maxLength) {
            warning.textContent = ''; // Không hiển thị cảnh báo nếu hợp lệ
        } else {
            warning.textContent = `Độ dài hiện tại: ${fieldLength}. Vui lòng nhập từ ${minLength} đến ${maxLength} ký tự để tối ưu hóa chuẩn SEO.`;
        }
    }

    $(document).ready(function() {
        $("#uploadButton").click(function(e) {
            e.preventDefault();
            let data = new FormData();
            data.append('uploadImg', $('#image')[0].files[0]);
            data.append('current_url', window.location.href);

            $.ajax({
                url: "{{ route('upload.image') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#thumbnail').val(res.image_name);
                    $('#preview-image').show();
                },
                error: function(err) {
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });
</script>
@endsection