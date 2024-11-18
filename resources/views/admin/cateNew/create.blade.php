@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Thêm mới danh mục bài viết</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Danh mục bài viết</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageFormCateNew" action="{{ route('cateNews.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('cateNews.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm" id="submit" type="submitCateNew"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                    <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
                </div>
            </div>
            <div class="card-body border-top p-9">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Tên danh mục <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" oninput="checkDuplicate()">
                            <span id="name-error" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            <label for="">URL danh mục bài viết <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" oninput="checkDuplicate()">
                            <span id="slug-error" style="color: red;"></span>
                        </div>
                        <div class="mb-3">
                            <label for="related_pro" class="form-label">Sản phẩm liên quan: </label>
                            <select class="related_pro form-control" name="related_pro[]" id="related_pro" multiple="multiple"></select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select name="parent_id" id="parent_id" class="form-control" size="12" style="width: 100%;">
                                <option value="0">Chọn danh mục</option>
                                @foreach($cateNewParents as $category)
                                @include('admin.cateNew.partials.category_add', ['category' => $category, 'level' => 0, 'selected' => old('parent_id', $category->parent_id)])
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
                        <input type="text" name="title_seo" class="form-control" value="{{ old('title_seo') }}" id="title_seo" onkeyup="delayedValidate('title_seo', 'titleSeoWarning', 50, 60)">
                        <span class="text-danger" id="titleSeoWarning"></span>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">Thẻ từ khóa <div class="warningMenu">*</div>
                    </div>
                    <div class="col-8 d-flex align-items-center pb-3">
                        <input type="text" name="keyword_seo" class="form-control" value="{{ old('keyword_seo') }}">
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line">Thẻ mô tả <div class="warningMenu">*</div>
                    </div>
                    <div class="col-8">
                        <textarea name="des_seo" class="form-control" id="des_seo" rows="5" onkeyup="delayedValidate('des_seo', 'desSeoWarning', 150, 160)">{{ old('des_seo') }}</textarea>
                        <span class="text-danger" id="desSeoWarning"></span>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" id="submit" type="submitCateNew"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
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

            // Kiểm tra nếu name hoặc slug là "blogs"
            if (name === "blogs" || slug === "blogs") {
                if (name === "blogs") {
                    document.getElementById('name-error').innerText = 'Tên không được trùng.';
                }
                if (slug === "blogs") {
                    document.getElementById('slug-error').innerText = 'Url không được trùng.';
                }
                return;
            }
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
                    url: "{{ route('cateNews.checkName') }}",
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
    });
</script>
@endsection