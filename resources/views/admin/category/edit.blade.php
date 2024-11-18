@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chỉnh sửa danh mục sản phẩm</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Danh mục sản phẩm</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImgForm" action="{{ route('categories.update', ['id' => $category->id]) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @if (!empty($category))
            <input type="hidden" name="id" value="{{ $category->id }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit" id="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                    <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Xóa</button> -->
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
                        @include("admin.category.shared.edit-config")
                    </div>
                    <div class="tab-pane fade" id="wallet-tab" role="tabpanel">
                        @include("admin.category.shared.edit-seo")
                    </div>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm " type="submit" id="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </form>
        @can('category-delete')
        <form id="deleteForm-{{ $category->id }}" action="{{ route('categories.destroy', ['id' => $category->id]) }}" method="post" class="deleteForm">
            @csrf
            @method('Delete')
            <button class="btn btn-danger btn-sm" type="button" value="Delete" onclick="confirmDelete('{{ $category->id }}')" style="float: right; margin: 0 5px">
                <i class="fa-solid fa-eraser"></i> Xóa
            </button>
        </form>
        @endcan
    </div>
</div>
@endsection

@section('css')
<style>
    .toast-top-center>div {
        width: 400px !important;
    }
</style>
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

    function checkDuplicate() {
        const name = document.getElementById('name').value;
        // console.log(slug);
        // Xóa thông báo lỗi trước đó
        document.getElementById('name-error').innerText = "";

        $.ajax({
            url: " {{ route('categories.checkName') }} ",
            type: 'POST',
            data: {
                name: name,
                id: '{{ $category->id }}',
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data.name_exists) {
                    document.getElementById('name-error').innerText = 'Tên đã tồn tại';
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
    
    // $(document).ready(function() {
    //     $("#uploadButton").click(function(e) {
    //         e.preventDefault();
    //         let data = new FormData();
    //         data.append('uploadImg', $('#image')[0].files[0]);
    //         data.append('current_url', window.location.href);

    //         $.ajax({
    //             url: "{{ route('upload.image') }}",
    //             method: "POST",
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             data: data,
    //             processData: false,
    //             contentType: false,
    //             success: function(res) {
    //                 $('#thumbnail').val(res.image_name);
    //                 $('#preview-image').show();
    //             },
    //             error: function(err) {
    //                 alert("An error occurred. Please try again. 1");
    //             }
    //         });
    //     });
    // });

    function confirmDelete(id) {
        toastr.warning(`
        <div>Các danh mục con thuộc danh mục này sẽ bị xóa. Bạn muốn xóa chứ?</div>
        <div style="margin-top: 15px;">
            <button type="button" id="confirmButton" class="btn btn-danger btn-sm" style="margin-right: 10px;">Xóa</button>
            <button type="button" id="cancelButton" class="btn btn-secondary btn-sm">Hủy</button>
        </div>
    `, 'Cảnh báo', {
            closeButton: false,
            timeOut: 0, // Vô hiệu hóa tự động loại bỏ
            extendedTimeOut: 0,
            tapToDismiss: false,
            positionClass: "toast-top-center",
            onShown: function() {
                // Xử lý khi người dùng nhấn "Xóa"
                document.getElementById('confirmButton').addEventListener('click', function() {
                    toastr.clear(); // Xóa thông báo toastr
                    document.getElementById('deleteForm-' + id).submit(); // Gửi form để xóa
                });

                // Xử lý khi người dùng nhấn "Hủy"
                document.getElementById('cancelButton').addEventListener('click', function() {
                    toastr.remove(); // Xóa thông báo toastr khi nhấn nút "Hủy"
                });
            }
        });
    }
</script>
@endsection