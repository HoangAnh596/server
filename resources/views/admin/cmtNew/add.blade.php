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
        <form id="uploadImageFormCateNew" action="{{ route('comments.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('comments.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm" id="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                    <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
                </div>
            </div>
            <div class="card-body border-top p-9">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Tên người bình luận <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            <span id="name-error" style="color: red;"></span>
                        </div>
                        <div class="mb-3">
                            <label for="comment_pro" class="form-label">Sản phẩm: </label>
                            <select class="comment_pro form-control" name="product_id" id="comment_pro"></select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Email người bình luận <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            <span id="email-error" style="color: red;"></span>
                        </div>
                        <div class="mb-3" id="comment-cate-container">
                            <label for="comment_cate" class="form-label">Comments cha: </label>
                            <select class="comment_cate form-control" name="parent_id" id="comment_cate"></select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nội dung bình luận <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                    <textarea name="content" style="width: 100%;" rows="4">{{ old('content') }}</textarea>
                    <span id="name-error" style="color: red;"></span>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" id="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
            </div>
        </form>
    </div>
</div>

@endsection

@section('css')
<style>
    #comment-cate-container {
        display: none;
    }
</style>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        // Xử lý sản phẩm liên quan select2
        $('.comment_pro').select2({
            placeholder: 'select',
            allowClear: true,
        });
        $("#comment_pro").select2({
            ajax: {
                url: "{{ route('comments.tim-kiem') }}",
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

        // Nếu đã có danh mục bình luận cha từ backend (PHP), hiển thị select comment_cate
        if ($('#comment_cate option').length > 1) { // Kiểm tra nếu đã có option (ngoại trừ "Chọn danh mục")
            $("#comment-cate-container").show();
        } else {
            $("#comment-cate-container").hide();
        }

        // Khi chọn sản phẩm, hiển thị/ẩn comment_cate
        $('#comment_pro').on('change', function(e) {
            var productId = $(this).val();

            if (productId) {
                // Gọi AJAX để lấy các comment cha liên quan đến sản phẩm được chọn
                $.ajax({
                    url: "{{ route('comments.parent') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        product_id: productId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                    // Clear các option cũ trong select comment_cate
                        $('#comment_cate').empty();
                        
                        // Thêm option mặc định
                        $('#comment_cate').append('<option value="0">Chọn danh mục</option>');

                        // Kiểm tra nếu có comment cha
                        if (data.length > 0) {
                            // Thêm các comment cha vào select comment_cate
                            $.each(data, function(index, comment) {
                                $('#comment_cate').append(new Option(comment.name, comment.id));
                            });

                            // Hiển thị select comment_cate
                            $("#comment-cate-container").show();
                        } else {
                            // Nếu không có comment cha, ẩn comment_cate
                            $("#comment-cate-container").hide();
                        }
                    }
                });
            } else {
                // Nếu không có sản phẩm nào được chọn, ẩn comment_cate
                $("#comment-cate-container").hide();
            }
        });
    });
</script>
@endsection