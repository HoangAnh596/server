@extends('layouts.app')
@section('content')
<div class="card shadow">
    <div class="text-center mt-4">
        <h1 class="h4 text-gray-900 mb-4">Tạo mới Vai trò!</h1>
    </div>
    <form class="user" action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
            <div>
                <button class="btn btn-primary btn-sm" id="submit" type="submitCateNew"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
            </div>
        </div>
        <div class="text-dark card-body border-top">
            <div class="form-group">
                <label for="">Tên vai trò <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                <span id="name-error" style="color: red;"></span>
            </div>
            <div class="form-group">
                <label for="">Mô tả vai trò <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                <textarea class="form-control" name="display_name" rows="4">{{ old('display_name') }}</textarea>
                <span id="name-error" style="color: red;"></span>
            </div>
            <div class="row permiss">
                <div class="col-md-12">
                    <label>
                        <input type="checkbox" class="checkAll">
                        Chọn tất cả
                    </label>
                </div>
                @foreach($permissionsParent as $parent)
                <div class="card checkbox-all text-bg-primary mb-3 col-md-12">
                    <div class="card-header">
                        <label>
                            <input type="checkbox" class="checkbox_wrapper">
                            Module {{ $parent->display_name }}
                        </label>
                    </div>
                    <div class="d-flex justify-content-center">
                        @foreach($parent->permissionsChild as $child)
                        <div class="card-body">
                            <label>
                                <input type="checkbox" class="checkbox_childrent" name="permission_id[]" value="{{ $child->id }}">
                                {{ $child->display_name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </form>
</div>
@endsection

@section('css')
<style>
    .permiss {
        margin: 0;
    }

    .permiss .card {
        padding: 0;
    }

    .permiss .card-header {
        background-color: #76b900;
    }

    .permiss .card-header label {
        margin-bottom: 0;
    }

    .permiss input[type="checkbox"] {
        transform: scale(1.2);
    }
</style>
@endsection
@section('js')
<script>
    $(function() {
        // Khi click vào checkbox cha (checkbox_wrapper)
        $('.checkbox_wrapper').on('click', function() {
            // Tìm tất cả các checkbox con (checkbox_childrent) thuộc module hiện tại và thay đổi trạng thái dựa trên checkbox cha
            $(this).parents('.checkbox-all').find('.checkbox_childrent').prop('checked', $(this).prop('checked'));
        });

        // Khi click vào checkbox con (checkbox_childrent)
        $('.checkbox_childrent').on('click', function() {
            // Lấy container của module hiện tại
            let $parentModule = $(this).closest('.checkbox-all');

            // Kiểm tra nếu tất cả các checkbox con đều được chọn
            let allChecked = $parentModule.find('.checkbox_childrent:checked').length === $parentModule.find('.checkbox_childrent').length;

            // Thay đổi trạng thái của checkbox cha dựa trên trạng thái của tất cả checkbox con
            $parentModule.find('.checkbox_wrapper').prop('checked', allChecked);
        });

        // Chức năng chọn tất cả các checkbox trên toàn trang
        $('.checkAll').on('click', function() {
            let isChecked = $(this).prop('checked');
            // Chọn hoặc bỏ chọn tất cả các checkbox
            $('.checkbox_childrent, .checkbox_wrapper').prop('checked', isChecked);
        });
    });
</script>
@endsection