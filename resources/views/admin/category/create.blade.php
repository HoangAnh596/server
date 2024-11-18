@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Thêm mới danh mục sản phẩm</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Danh mục sản phẩm</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageForm" action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                    <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
                </div>
            </div>
            <div class="card-body border-top p-9">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info-tab" type="button" role="tab">
                            <i class="bi bi-info-circle-fill"></i>
                            Cấu hình sản phẩm
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#wallet-tab" type="button" role="tab">
                            <i class="bi bi-wallet2"></i>
                            Cấu hình SEO
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="info-tab" role="tabpanel">
                        @include("admin.category.shared.add-config")
                    </div>
                    <div class="tab-pane fade" id="wallet-tab" role="tabpanel">
                        @include("admin.category.shared.add-seo")
                    </div>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('cntt/js/slug.js') }}"></script>
<script>

    let timeout = null;
    let updateSlug = true;

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

    function validateSlug(slug) {
        // Biểu thức chính quy để kiểm tra định dạng của slug
        const regex = /^[a-z0-9]+(-[a-z0-9]+)*$/;
        return regex.test(slug);
    }

    function checkDuplicate() {
        clearTimeout(timeout);
        timeout = setTimeout(async function() {
            if (updateSlug) {
                await createSlug();
            }

            const name = document.getElementById('name').value;
            const slug = document.getElementById('slug').value;

            // Xóa thông báo lỗi trước đó
            document.getElementById('name-error').innerText = "";
            document.getElementById('slug-error').innerText = "";
            // Chỉ kiểm tra nếu slug không rỗng
            if (updateSlug && name.trim() !== "") {
                await createSlug();
            }
            // Kiểm tra định dạng slug
            if (slug.trim() === "") {
                document.getElementById('slug-error').innerText = 'Url không được để trống';
            } else if (!validateSlug(slug)) {
                document.getElementById('slug-error').innerText = 'Url không hợp lệ. Chỉ chấp nhận chữ cái thường, số và dấu gạch ngang.';
            } else {
                // Nếu slug hợp lệ, kiểm tra trùng lặp
                await $.ajax({
                    url: "{{ route('categories.checkName') }}",
                    type: 'POST',
                    data: {
                        name: name,
                        slug: slug,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.name_exists) {
                            document.getElementById('name-error').innerText = 'Tên đã tồn tại';
                        }

                        if (data.slug_exists) {
                            document.getElementById('slug-error').innerText = 'Url đã tồn tại';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }, 1000);
    }
    // Đặt updateSlug là true khi tên thay đổi
    document.getElementById('name').addEventListener('input', function() {
        updateSlug = true;
        checkDuplicate();
    });

    // Đặt updateSlug là false khi slug thay đổi
    document.getElementById('slug').addEventListener('input', function() {
        updateSlug = false;
        checkDuplicate();
    });

    $(document).ready(function() {
        $('#current_url').val(window.location.href);
        $("#uploadButton").click(function(e) {
            e.preventDefault();
            let formData = new FormData($("#uploadImageForm")[0]);
            console.log(formData);

            $.ajax({
                url: "{{ route('upload.image') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                _token: "{{ csrf_token() }}",
                success: function(response) {
                    $('#thumbnail').val(response.image_name);
                    $('#preview-image').show();
                },
                error: function(response) {
                    alert("An error occurred. Please try again.");
                    console.log(response);
                }
            });
        });
    });
</script>
@endsection