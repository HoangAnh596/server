@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chỉnh sửa danh mục bài viết</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Danh mục bài viết</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form action="{{ route('cateNews.update', $category->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @if (!empty($category))
            <input type="hidden" name="id" value="{{ $category->id }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('cateNews.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit" id="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                    <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Xóa</button> -->
                </div>
            </div>
            <div class="card-body border-top p-9">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3 col-xs-12">
                            <label for="name" class="form-label">Tên danh mục <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $category->name ?? '') }}">
                        </div>
                        <div class="mb-3 col-xs-12">
                            <label for="slug" class="form-label">URL danh mục bài viết: </label>
                            <input type="text" id="slug" class="form-control" name="slug" value="{{ old('slug', $category->slug ?? '') }}" disabled>
                        </div>
                        <div class="mb-3 col-xs-12">
                            <label for="related_pro" class="form-label">Sản phẩm liên quan: </label>
                            <select class="related_pro form-control" name="related_pro[]" id="related_pro" multiple="multiple">
                                @if(!empty($relatedPro))
                                @foreach($relatedPro as $val)
                                <option value="{{ $val->id }}"
                                    {{ in_array($val->id, old('related_pro', json_decode($category->related_pro, true) ?? [])) ? 'selected' : '' }}>
                                    {{ $val->name }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group mb-3 col-xs-12">
                            <label for="parent_id">Danh mục cha:</label>
                            <select class="form-control" id="parent_id" name="parent_id" size="12" style="width: 100%;">
                                <option value="0">Danh mục cha</option>
                                @foreach($categories as $cat)
                                @include('admin.cateNew.partials.category-edit', ['category' => $cat, 'level' => 0, 'selected' => old('parent_id', $category->parent_id)])
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <h4>Cấu hình SEO :</h4>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">Tiêu đề trang <div class="warningMenu">*</div>
                    </div>
                    <div class="col-8 pb-3">
                        <input type="text" name="title_seo" class="form-control" value="{{old('title_seo', $category->title_seo ?? '') }}" id="title_seo" onkeyup="delayedValidate('title_seo', 'titleSeoWarning', 50, 60)">
                        <span class="text-danger" id="titleSeoWarning"></span>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">Thẻ từ khóa <div class="warningMenu">*</div>
                    </div>
                    <div class="col-8 d-flex align-items-center pb-3">
                        <input type="text" name="keyword_seo" class="form-control" value="{{ old('keyword_seo', $category->keyword_seo ?? '') }}">
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line">Thẻ mô tả <div class="warningMenu">*</div>
                    </div>
                    <div class="col-8">
                        <textarea name="des_seo" class="form-control" id="des_seo" rows="5" onkeyup="delayedValidate('des_seo', 'desSeoWarning', 150, 160)">{{ old('des_seo', $category->des_seo ?? '') }}</textarea>
                        <span class="text-danger" id="desSeoWarning"></span>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm " type="submit" id="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </form>
        @can('cateNew-delete')
        <form id="deleteForm-{{ $category->id }}" action="{{ route('cateNews.destroy', ['id' => $category->id]) }}" method="post" class="deleteForm">
            @csrf
            @method('Delete')
            <button class="btn btn-danger btn-sm" type="button" onclick="confirmDelete('{{ $category->id }}')" style="float: right; margin: 0 5px">
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

    $(document).ready(function() {
        // Xử lý sản phẩm liên quan select2
        $('.related_pro').select2({
            placeholder: 'select',
            allowClear: true,
        });
        $("#related_pro").select2({
            ajax: {
                url: "{{ route('cateNews.tim-kiem') }}",
                type: "POST",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        name: params.term,
                        _token: "{{ csrf_token() }}",
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                            }
                        })
                    }
                }
            },
        });

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
                    alert("An error occurred. Please try again. 1");
                }
            });
        });
    });

    function confirmDelete(id) {
        toastr.warning(`
        <div>Các bài viết con thuộc danh mục này sẽ bị xóa. Bạn muốn xóa chứ?</div>
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